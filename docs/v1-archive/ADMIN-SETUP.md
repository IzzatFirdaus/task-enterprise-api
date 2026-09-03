# Admin System Setup

## Architecture overview

The application keeps the regular user system and the enterprise admin system separated but connected to the same database. Regular users authenticate at `/login` and interact with their own tasks. Administrators authenticate at `/admin/login` and access protected admin routes for user, task, audit, and settings management.

```text
User system            Admin system
----------            ------------
/login                 /admin/login
/dashboard             /admin/dashboard
/api/user/*           /api/admin/*

Shared database:
- users
- tasks
- roles
- role_user
- audit_logs
```

## Role model and permission matrix

The RBAC layer is implemented through dedicated middleware and helpers on the `User` model. Role checks use `role:admin`, `role:super_admin`, and the model methods `hasRole()`, `isAdmin()`, `isSuperAdmin()`, and `canModerate()`.

| Role | Description | Allowed access |
|---|---|---|
| `super_admin` | Full system authority | All users, tasks, audit logs, settings, and role edits |
| `admin` | Operational admin | User management, task moderation, limited audit metadata |
| `moderator` | Task oversight | Task moderation only |
| `user` | Standard end-user role | Own task CRUD only |

## Database schema reference

### Roles table

```sql
CREATE TABLE roles (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    is_system BOOLEAN NOT NULL DEFAULT false,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Role-user pivot

```sql
CREATE TABLE role_user (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    role_id BIGINT UNSIGNED NOT NULL,
    assigned_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE (user_id, role_id),
    CONSTRAINT fk_role_user_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_role_user_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);
```

### Audit logs

```sql
CREATE TABLE audit_logs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    admin_id BIGINT UNSIGNED NULL,
    action VARCHAR(255) NOT NULL,
    model_type VARCHAR(255) NULL,
    model_id BIGINT UNSIGNED NULL,
    changes JSON NULL,
    ip_address VARCHAR(255) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP NULL,
    CONSTRAINT fk_audit_admin FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Users table additions

```sql
ALTER TABLE users
    ADD COLUMN is_suspended BOOLEAN NOT NULL DEFAULT false,
    ADD COLUMN suspended_at TIMESTAMP NULL,
    ADD COLUMN suspension_reason TEXT NULL,
    ADD COLUMN last_admin_action_at TIMESTAMP NULL;
```

## Authentication flow

1. Regular users log in with the standard Breeze flow at `/login`.
2. Administrators log in with the dedicated admin form at `/admin/login`.
3. The request passes through `role:admin` or `role:super_admin` middleware before entering admin routes.
4. Any access denial, role change, suspend action, or login event is written to `audit_logs` with the request IP and user agent.

## Admin route map

### Web routes

| Method | Endpoint | Required middleware | Purpose |
|---|---|---|---|
| GET | `/admin/login` | `guest` | Admin sign-in page |
| POST | `/admin/login` | `guest`, `throttle:5,1` | Admin authentication |
| GET | `/admin/dashboard` | `auth`, `role:admin,super_admin` | Admin overview |
| GET | `/admin/users` | `auth`, `role:admin,super_admin` | User management |
| GET | `/admin/users/{user}/edit` | `auth`, `role:admin,super_admin` | Edit user form |
| PUT | `/admin/users/{user}` | `auth`, `role:admin,super_admin` | Update user |
| POST | `/admin/users/{user}/suspend` | `auth`, `role:admin,super_admin` | Suspend user |
| POST | `/admin/users/{user}/unsuspend` | `auth`, `role:admin,super_admin` | Unsuspend user |
| DELETE | `/admin/users/{user}` | `auth`, `role:admin,super_admin` | Delete user |
| GET | `/admin/tasks` | `auth`, `role:admin,super_admin,moderator` | Task moderation |
| PUT | `/admin/tasks/{task}/reassign` | `auth`, `role:admin,super_admin,moderator` | Reassign task |
| DELETE | `/admin/tasks/{task}` | `auth`, `role:admin,super_admin,moderator` | Delete task |
| GET | `/admin/audit-logs` | `auth`, `role:super_admin` | Audit log review |
| GET | `/admin/audit-logs/export` | `auth`, `role:super_admin` | CSV export |
| GET | `/admin/settings` | `auth`, `role:super_admin` | Settings page |
| PUT | `/admin/settings` | `auth`, `role:super_admin` | Update settings |

### API routes

| Method | Endpoint | Required middleware | Purpose |
|---|---|---|---|
| POST | `/api/admin/login` | `throttle:5,1` | Admin API login |
| GET | `/api/admin/users` | `auth:sanctum`, `role:admin,super_admin`, `throttle:60,1` | List users |
| PUT | `/api/admin/users/{user}` | `auth:sanctum`, `role:admin,super_admin`, `throttle:60,1` | Update user |
| POST | `/api/admin/users/{user}/suspend` | `auth:sanctum`, `role:admin,super_admin`, `throttle:10,1` | Suspend user |
| POST | `/api/admin/users/{user}/unsuspend` | `auth:sanctum`, `role:admin,super_admin`, `throttle:10,1` | Unsuspend user |
| POST | `/api/admin/users/{user}/roles/{role}` | `auth:sanctum`, `role:admin,super_admin`, `throttle:20,1` | Assign role |
| GET | `/api/admin/tasks` | `auth:sanctum`, `role:admin,super_admin`, `throttle:60,1` | Task list |
| PUT | `/api/admin/tasks/{task}` | `auth:sanctum`, `role:admin,super_admin`, `throttle:60,1` | Reassign task |
| POST | `/api/admin/tasks/bulk-action` | `auth:sanctum`, `role:admin,super_admin`, `throttle:20,1` | Bulk task actions |
| GET | `/api/admin/audit-logs` | `auth:sanctum`, `role:super_admin`, `throttle:30,1` | Audit records |
| GET | `/api/admin/audit-logs/export` | `auth:sanctum`, `role:super_admin`, `throttle:30,1` | CSV export |
| GET | `/api/admin/analytics/*` | `auth:sanctum`, `role:admin,super_admin`, `throttle:60,1` | Analytics |
| GET | `/api/admin/settings` | `auth:sanctum`, `role:super_admin`, `throttle:30,1` | Settings payload |
| PUT | `/api/admin/settings` | `auth:sanctum`, `role:super_admin`, `throttle:30,1` | Update settings |

## Audit logging workflow

The audit trail captures who performed an action, what changed, and where the request came from. Every privileged action calls `AuditLog::create()` with:

- `admin_id`
- `action`
- `model_type`
- `model_id`
- `changes`
- `ip_address`
- `user_agent`
- `created_at`

This supports review, security investigation, and exportable administrative reporting. Super-admin roles have access to the full record set, while lower roles can only access the scopes appropriate to their route permissions.

## Seeded accounts

| Role | Email | Password |
|---|---|---|
| `super_admin` | `admin@example.com` | `password` |
| `admin` | `admin2@example.com` | `password` |
| `moderator` | `moderator@example.com` | `password` |

## Security guidelines

- Separate the admin and user authentication surfaces.
- Require CSRF tokens on all web forms.
- Enforce `role:*` middleware on every admin endpoint.
- Log `request()->ip()` and `request()->userAgent()` on every protected action.
- Keep super-admin-only operations restricted to the `super_admin` role.
- Consider `throttle` on login and sensitive admin actions in addition to the default Laravel protections.

## Troubleshooting

### Admin login fails

Check that the user has a valid admin role and is not marked as suspended.

### 403 on protected admin routes

Confirm the user has `admin` or `super_admin` access and the route is wrapped by the correct middleware.

### Missing audit entries

Check the controller or middleware action and verify that `AuditLog::create()` receives the request IP, user agent, and a valid action payload.

## Validation

```bash
php artisan migrate
php artisan test --filter=AdminSystemTest
php artisan route:list --path=admin
```
