# 👑 ADMIN SYSTEM OVERVIEW

Complete admin interface for enterprise task management system.

---

## System Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                     Task Management App                      │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌──────────────────┐           ┌──────────────────────┐    │
│  │  User System     │           │   Admin System (NEW) │    │
│  │                  │           │                      │    │
│  │ /login           │           │ /admin/login         │    │
│  │ /dashboard       │           │ /admin/dashboard     │    │
│  │ /api/user/tasks  │           │ /admin/users         │    │
│  │                  │           │ /admin/tasks         │    │
│  │ Livewire UI      │           │ /admin/audit-logs    │    │
│  │ Task CRUD        │           │ /admin/settings      │    │
│  │                  │           │                      │    │
│  │ Roles:           │           │ Roles:               │    │
│  │ - user (default) │           │ - admin              │    │
│  │                  │           │ - super_admin        │    │
│  │                  │           │ - moderator          │    │
│  └──────────────────┘           │                      │    │
│         ▲                        │ API Endpoints:       │    │
│         │                        │ /api/admin/*         │    │
│         │                        │                      │    │
│         └────────────────────────│ Blade Views          │    │
│            Shared Database       │ Audit Trail          │    │
│            (users, tasks, roles) │ RBAC System          │    │
│                                  └──────────────────────┘    │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

---

## Database Schema

### Roles Table
```
roles
├── id (PK)
├── name (unique) → 'super_admin', 'admin', 'moderator', 'user'
├── description → 'Full system access', 'User/task management', etc.
├── is_system (bool) → true for built-in roles
├── created_at
└── updated_at
```

### Role-User Pivot
```
role_user
├── id (PK)
├── user_id (FK → users.id, CASCADE)
├── role_id (FK → roles.id, CASCADE)
└── assigned_at
```

### Audit Logs
```
audit_logs
├── id (PK)
├── admin_id (FK → users.id, CASCADE)
├── action (enum) → 'create', 'update', 'delete', 'suspend'
├── model_type → 'User', 'Task', 'Role', 'Settings'
├── model_id → ID of affected model
├── changes (JSON) → {before: {...}, after: {...}}
├── ip_address → 192.168.1.1
├── user_agent → Mozilla/5.0...
├── created_at
└── updated_at

Indexes:
  - admin_id
  - created_at
  - model_type
  - (admin_id, created_at)
```

### Users Table Updates
```
users (existing)
├── id
├── name
├── email
├── password
├── ...existing columns...
│
├── is_suspended (bool, default: false) [NEW]
├── suspended_at (nullable timestamp) [NEW]
├── suspension_reason (nullable text) [NEW]
├── last_admin_action_at (nullable timestamp) [NEW]
│
└── relationships:
    ├── tasks() → HasMany
    ├── roles() → BelongsToMany
    └── auditLogs() → HasMany (admin actions performed)
```

### Admin Settings (Optional)
```
admin_settings
├── id (PK)
├── key → 'site_name', 'admin_email', 'max_users', etc.
├── value → JSON or string
├── updated_by (FK → users.id)
├── updated_at
└── note
```

---

## Roles & Permissions

### Super Admin (`super_admin`)
```
Permissions:
  ✅ View all users, tasks, audit logs
  ✅ Create/edit/delete any user
  ✅ Assign/remove any role
  ✅ Suspend/unsuspend users (with reason)
  ✅ Delete any task
  ✅ Reassign tasks between users
  ✅ View audit trail
  ✅ Manage admin settings
  ✅ Access all admin features
  ✅ View sensitive data (IP addresses, user agents)

Restrictions:
  ❌ Cannot delete themselves
  ❌ Cannot remove their own admin role
  ❌ Cannot delete last super_admin
```

### Admin (`admin`)
```
Permissions:
  ✅ View all users, tasks
  ✅ Create/edit users
  ✅ Suspend/unsuspend users
  ✅ Delete users
  ✅ Assign/remove roles (except admin roles)
  ✅ Delete/reassign tasks
  ✅ View limited audit logs (exclude settings changes)

Restrictions:
  ❌ Cannot view other admins' actions
  ❌ Cannot manage other admins or super_admins
  ❌ Cannot change system settings
  ❌ Cannot view full audit trail
```

### Moderator (`moderator`)
```
Permissions:
  ✅ View all tasks
  ✅ Delete inappropriate tasks
  ✅ Reassign tasks
  ✅ View user profiles

Restrictions:
  ❌ Cannot edit users
  ❌ Cannot suspend users
  ❌ Cannot change roles
  ❌ Cannot view audit logs
  ❌ Cannot view sensitive data
```

### User (`user`)
```
Permissions:
  ✅ Create/edit/delete own tasks
  ✅ View own dashboard
  ✅ View own tasks only

Restrictions:
  ❌ Cannot see other users' tasks
  ❌ Cannot access admin area
  ❌ Cannot manage other users
  ❌ Cannot moderate content
```

---

## Routes Structure

### Web Routes (Session-based)

```
GET    /                          → Redirect to /login or /dashboard
GET    /login                     → User login form
POST   /login                     → Process user login
GET    /register                  → User register form
POST   /register                  → Process user registration
GET    /dashboard                 → User dashboard (Livewire)
POST   /logout                    → Process user logout

GET    /admin/login               → Admin login form (NEW)
POST   /admin/login               → Process admin login (NEW)
GET    /admin/dashboard           → Admin dashboard (NEW)
GET    /admin/users               → User management table (NEW)
GET    /admin/users/{id}          → User details (NEW)
GET    /admin/users/{id}/edit     → Edit user form (NEW)
PUT    /admin/users/{id}          → Update user (NEW)
DELETE /admin/users/{id}          → Delete user (NEW)
POST   /admin/users/{id}/suspend  → Suspend user (NEW)
DELETE /admin/users/{id}/suspend  → Unsuspend user (NEW)
POST   /admin/tasks/{id}/reassign → Reassign task (NEW)
DELETE /admin/tasks/{id}          → Delete task (NEW)
GET    /admin/audit-logs          → View audit trail (super_admin only) (NEW)
GET    /admin/settings            → Settings page (super_admin only) (NEW)
PUT    /admin/settings            → Update settings (super_admin only) (NEW)
```

### API Routes (Token-based via Sanctum)

```
POST   /api/user/login            → User API login (existing)
GET    /api/user/tasks            → List own tasks (existing)
POST   /api/user/tasks            → Create task (existing)
GET    /api/user/tasks/{id}       → Get task (existing)
PUT    /api/user/tasks/{id}       → Update task (existing)
DELETE /api/user/tasks/{id}       → Delete task (existing)

GET    /api/admin/users           → List all users (admin+) (NEW)
GET    /api/admin/users/{id}      → Get user (admin+) (NEW)
PUT    /api/admin/users/{id}      → Update user (admin+) (NEW)
DELETE /api/admin/users/{id}      → Delete user (super_admin only) (NEW)
POST   /api/admin/users/{id}/suspend → Suspend user (admin+) (NEW)
DELETE /api/admin/users/{id}/suspend → Unsuspend user (admin+) (NEW)
POST   /api/admin/users/{id}/roles/{role} → Assign role (super_admin only) (NEW)
DELETE /api/admin/users/{id}/roles/{role} → Remove role (super_admin only) (NEW)

GET    /api/admin/tasks           → List all tasks (moderator+) (NEW)
GET    /api/admin/tasks/{id}      → Get task (moderator+) (NEW)
PUT    /api/admin/tasks/{id}      → Reassign task (moderator+) (NEW)
DELETE /api/admin/tasks/{id}      → Delete task (moderator+) (NEW)
POST   /api/admin/tasks/bulk-action → Bulk actions (admin+) (NEW)

GET    /api/admin/audit-logs      → List audit logs (super_admin only) (NEW)
GET    /api/admin/audit-logs/{id} → Get log (super_admin only) (NEW)
GET    /api/admin/audit-logs/export → Export CSV (super_admin only) (NEW)

GET    /api/admin/settings        → Get settings (super_admin only) (NEW)
PUT    /api/admin/settings        → Update settings (super_admin only) (NEW)

GET    /api/admin/analytics/dashboard → Stats (admin+) (NEW)
GET    /api/admin/analytics/users → User stats (admin+) (NEW)
GET    /api/admin/analytics/tasks → Task stats (admin+) (NEW)
```

---

## Controllers to Create

```
app/Http/Controllers/Admin/
├── AdminController.php
│   ├── dashboard()
│   └── stats()
│
├── UserManagementController.php
│   ├── index()
│   ├── show($id)
│   ├── edit($id)
│   ├── update(UpdateUserRequest $request, $id)
│   ├── destroy($id)
│   ├── suspend(SuspendUserRequest $request, $id)
│   ├── unsuspend($id)
│   ├── assignRole($id, $roleId)
│   └── removeRole($id, $roleId)
│
├── TaskModerationController.php
│   ├── index()
│   ├── show($id)
│   ├── reassign(Request $request, $id)
│   ├── destroy($id)
│   └── bulkAction(Request $request)
│
├── AuditLogController.php (super_admin only)
│   ├── index()
│   ├── show($id)
│   └── export()
│
├── AdminSettingsController.php (super_admin only)
│   ├── edit()
│   └── update(AdminSettingsRequest $request)
│
└── Auth/AdminLoginController.php
    ├── create()
    └── store(Request $request)
```

---

## Middleware to Create

```
app/Http/Middleware/
├── AdminMiddleware.php
│   └── Check if user has admin role
│       └── Deny access if not admin
│
├── RoleMiddleware.php
│   └── Check if user has one of specified roles
│       └── Usage: middleware('role:admin,super_admin')
│
├── SuperAdminMiddleware.php
│   └── Check if user is ONLY super_admin
│       └── Deny access if not super_admin
│
└── CheckSuspension.php
    └── Prevent suspended users from accessing system
        └── Redirect to login with message
```

---

## Views to Create

```
resources/views/
├── layouts/
│   └── admin.blade.php (NEW)
│       └── Admin navigation, layout, includes Livewire
│
├── admin/ (NEW)
│   ├── dashboard.blade.php
│   │   └── Stats cards, recent activity, quick actions
│   │
│   ├── users/
│   │   ├── index.blade.php
│   │   │   └── Table with pagination, search, filter, bulk actions
│   │   │
│   │   └── edit.blade.php
│   │       └── Form: name, email, roles, suspension
│   │
│   ├── tasks/
│   │   ├── index.blade.php
│   │   │   └── Table, filter, bulk actions
│   │   │
│   │   └── moderation.blade.php
│   │       └── Reassign, delete, audit history
│   │
│   ├── audit-logs.blade.php (super_admin only)
│   │   └── Searchable audit trail, export
│   │
│   └── settings.blade.php (super_admin only)
│       └── System configuration form
│
└── auth/
    └── admin-login.blade.php (NEW)
        └── Email, password form for admins
```

---

## Models

### Models to Create

```
app/Models/
├── Role.php (NEW)
│   └── BelongsToMany users
│   └── Scopes: isSystem(), notSystem()
│   └── Methods: isSuperAdmin(), isAdmin(), isModerator()
│
└── AuditLog.php (NEW)
    └── BelongsTo User (admin who performed action)
    └── Scopes: recent(), byAdmin(), byModel(), byAction()
    └── Methods: getModelAttribute(), human_action property
```

### Models to Update

```
app/Models/
└── User.php
    └── Add BelongsToMany roles
    └── Add HasMany auditLogs
    └── Add methods:
        - hasRole(string|array $roles): bool
        - hasAnyRole(array $roles): bool
        - hasAllRoles(array $roles): bool
        - isSuperAdmin(): bool
        - isAdmin(): bool
        - canManageUsers(): bool
        - canModerate(): bool
    └── Add accessor: is_admin property
    └── Add relationship: roles()
```

---

## Seeded Data

### Initial Roles
```
✅ super_admin — "Full system access"
✅ admin — "User and task management"
✅ moderator — "Task moderation only"
✅ user — "Regular user (default)"
```

### Initial Users (After Admin Seeder)
```
Regular Users (from existing seeder):
  ✅ alex@example.com / password (role: user)
  ✅ jordan@example.com / password (role: user)
  ✅ casey@example.com / password (role: user)

Admin Users (from admin seeder):
  ✅ admin@example.com / password (role: super_admin)
  ✅ admin2@example.com / password (role: admin)
  ✅ moderator@example.com / password (role: moderator)
```

### Initial Audit Logs
```
✅ Created roles (logged by super_admin seed)
✅ Created admin users (logged)
✅ Assigned roles (logged)
```

---

## Security Features

### Built-in Protections

1. **RBAC (Role-Based Access Control)**
   - Middleware checks `role:admin` on protected routes
   - Authorization checks prevent cross-role access

2. **Audit Trail**
   - Every admin action logged with: who, what, when, where (IP)
   - Changes recorded as before/after JSON

3. **Suspension System**
   - Suspended users cannot login
   - Suspension tracked with reason and timestamp
   - Audit log entry created

4. **Super Admin Protection**
   - Last super admin cannot be deleted
   - Last super admin role cannot be removed
   - Super admin actions tracked separately

5. **Rate Limiting**
   - /admin/login — 5 attempts per minute
   - /api/admin/* — 30 per minute per admin
   - /api/admin/*/suspend — 10 per minute

6. **CSRF Protection**
   - All forms protected with CSRF tokens
   - Laravel middleware enabled

7. **IP Logging**
   - Every admin action logs source IP
   - Useful for forensics

8. **Sensitive Data Protection**
   - Admin can view user password hashes (never shown)
   - IP addresses logged but not exposed to regular users
   - Audit logs viewable only by super_admin

---

## Feature Comparison

### User Dashboard
```
/dashboard
├── My Tasks (own only)
├── Create Task (own only)
├── Filter (own tasks)
├── Stats (own stats only)
└── Cannot access admin area
```

### Admin Dashboard
```
/admin/dashboard
├── System Overview
│   ├── Total Users
│   ├── Total Tasks
│   ├── Suspended Users
│   ├── Recent Activity
│   └── Charts
│
├── Quick Actions
│   ├── Manage Users
│   ├── Manage Tasks
│   ├── View Audit Logs (super_admin)
│   └── Settings (super_admin)
│
└── Recent Audit Log (last 10 entries)
```

### User Management
```
/admin/users
├── Search by email/name
├── Filter by role
├── Filter by status (active/suspended)
├── Actions:
│   ├── View profile
│   ├── Edit (name, email, roles)
│   ├── Suspend/Unsuspend
│   ├── Delete
│   └── View audit trail
│
└── Pagination (20 per page)
```

### Task Management
```
/admin/tasks
├── View all tasks (all users)
├── Search by title
├── Filter by status
├── Filter by user
├── Actions:
│   ├── View details
│   ├── Reassign to different user
│   ├── Delete
│   └── View task history
│
└── Pagination (20 per page)
```

### Audit Logs (Super Admin Only)
```
/admin/audit-logs
├── View all admin actions
├── Columns:
│   ├── Admin (who)
│   ├── Action (what: create, update, delete, suspend)
│   ├── Model (model type)
│   ├── Model ID
│   ├── Changes (before/after as collapsible JSON)
│   ├── IP Address
│   └── Timestamp
│
├── Filters:
│   ├── By admin
│   ├── By action
│   ├── By model type
│   └── By date range
│
├── Search by model ID
├── Export to CSV
└── Pagination (50 per page)
```

### Settings (Super Admin Only)
```
/admin/settings
├── Site Name
├── Admin Email
├── Max Users (optional)
├── Maintenance Mode (optional)
├── Default Role for New Users
├── Session Timeout
└── Last Updated By / At
```

---

## Testing Strategy

### Test Cases (Not Run, Just Provided)

```
tests/Feature/Admin/AdminApiTest.php

Authentication:
  ✅ test_admin_can_login_to_admin_area
  ✅ test_user_redirected_from_admin_login
  ✅ test_suspended_user_cannot_login
  ✅ test_admin_session_separate_from_user_session

Authorization:
  ✅ test_super_admin_can_access_all_admin_features
  ✅ test_admin_cannot_access_audit_logs
  ✅ test_admin_cannot_manage_other_admins
  ✅ test_moderator_can_moderate_tasks
  ✅ test_user_cannot_access_admin_area
  ✅ test_unauthenticated_user_cannot_access_admin

User Management:
  ✅ test_admin_can_list_all_users
  ✅ test_admin_can_edit_user
  ✅ test_admin_can_suspend_user
  ✅ test_admin_can_unsuspend_user
  ✅ test_admin_cannot_delete_themselves
  ✅ test_super_admin_can_delete_user
  ✅ test_last_super_admin_cannot_be_deleted
  ✅ test_admin_cannot_promote_to_super_admin

Task Moderation:
  ✅ test_admin_can_view_all_tasks
  ✅ test_admin_can_reassign_task
  ✅ test_admin_can_delete_task
  ✅ test_moderator_can_moderate_tasks

Audit Logging:
  ✅ test_user_creation_logged_in_audit
  ✅ test_user_suspension_logged_with_reason
  ✅ test_audit_log_includes_admin_id_and_ip
  ✅ test_changes_field_shows_before_after_values
  ✅ test_super_admin_can_view_all_audit_logs
  ✅ test_admin_cannot_view_audit_logs

Role Management:
  ✅ test_admin_can_assign_role_to_user
  ✅ test_admin_can_remove_role_from_user
  ✅ test_role_assignment_logged
  ✅ test_cannot_create_roles_via_api

Settings:
  ✅ test_super_admin_can_update_settings
  ✅ test_admin_cannot_update_settings
  ✅ test_settings_update_logged

Total: 35+ test cases
```

---

## File Counts (After Completion)

| Category | Count |
|----------|-------|
| Controllers | 6 (new) |
| Models | 2 (new) + 1 (updated) |
| Middleware | 3 (new) |
| Blade Views | 7+ (new) |
| Livewire Components | 0-3 (optional) |
| Migrations | 4 (new) |
| Seeders | 1 (new) + 1 (updated) |
| Requests | 3 (new) |
| Tests | 1 (new, not run) |
| Routes | Multiple (new) |
| Total New Files | 25-30 |

---

## Development Timeline

| Phase | Time | Deliverable |
|-------|------|-------------|
| 1-3 | 10 min | Database + Models + Middleware |
| 4-6 | 10 min | Controllers + Routes |
| 7-8 | 10 min | Views + Login |
| 9 | 5 min | Livewire components (optional) |
| 10-11 | 10 min | Tests + Seeding |
| 12-15 | 10 min | Documentation + Validation |
| **Total** | **~55 min** | **Complete Admin System** |

---

## Success Criteria

After completion, the system should:

✅ Allow super_admin to manage all aspects
✅ Allow admin to manage users and tasks (not other admins)
✅ Allow moderator to moderate tasks only
✅ Regular users cannot access admin area
✅ All actions logged in audit trail
✅ Suspended users cannot login
✅ Last super_admin cannot be deleted
✅ Admin login separate from user login
✅ All API endpoints require proper authentication
✅ All views responsive and styled
✅ All tests pass (when run)
✅ Code formatted with Pint
✅ Documentation complete

---

## Why This Matters for Your Portfolio

### Demonstrates Enterprise Skills

1. **RBAC** — Shows understanding of authorization systems
2. **Audit Trails** — Security and compliance awareness
3. **Separation of Concerns** — Admin system separate from user system
4. **API Design** — Proper endpoint structure and protection
5. **Database Design** — Proper normalization and relationships
6. **Middleware** — Custom authentication/authorization
7. **Security** — Rate limiting, CSRF, IP logging, role checking
8. **Testing** — Comprehensive test cases (even if not run)
9. **Documentation** — Professional documentation with diagrams

### Real-World Applicable

- Every web app needs admin interface
- Every SaaS needs RBAC
- Every system needs audit trails
- Skills directly transferable to production systems

### Complexity Increase

- User system: Task CRUD
- Admin system: User CRUD + role management + audit trails + settings

This is a **significant step up in complexity** that shows advanced Laravel skills.

---

**This admin system will be impressive proof of work for enterprise development positions!**
