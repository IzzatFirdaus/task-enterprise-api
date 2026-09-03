# Technical Architecture

## Status and Scope

- **Audit date:** 2026-09-03
- **Application:** Enterprise Task Management API and web dashboard
- **Runtime:** PHP 8.5 in the current development environment
- **Source of truth:** Registered routes, application code, migrations, configuration, views, and tests

This document describes the implementation that exists today. It does not describe planned product features unless they are explicitly listed under technical debt or roadmap boundaries.

## System Overview

The application is a Laravel monolith with two user-facing surfaces backed by the same database:

1. A session-authenticated personal task dashboard.
2. A session-authenticated administrative workspace for role-based user and task governance.
3. A token-authenticated JSON API for personal task operations and administrative operations.

The web and API surfaces share Eloquent models, role checks, validation rules, and audit logging. There is no separate admin authentication guard; the admin web login uses the normal session guard and relies on role middleware after authentication.

## Technology Stack

| Area | Current implementation |
|---|---|
| Backend framework | Laravel `^13.17` |
| Language/runtime | PHP `^8.3` dependency constraint; PHP 8.5 verified locally |
| Authentication | Laravel session authentication, Breeze `^2.4`, Sanctum `^4.0` |
| Reactive UI | Livewire `^4.4` |
| Server-rendered UI | Blade templates |
| Styling | Tailwind CSS `^4.3`, Tailwind forms plugin |
| Browser scripting | Alpine.js `^3.4`, managed by Livewire in the current entry point |
| Asset build | Vite `^8`, Laravel Vite plugin `^3.1` |
| Database | SQLite by default; MySQL, MariaDB, PostgreSQL, and SQL Server connections configured |
| Session/cache/queue defaults | Database-backed session, cache, and queue |
| Mail default | Log mailer |
| Tests | PHPUnit `^12.5`, Laravel test runner |
| Browser test dependency | Playwright `^1.62` is installed; no browser test suite is registered in the PHP test configuration |
| Code quality | Laravel Pint `^1.27` |

## Runtime Entry Points

- `public/index.php` is the HTTP entry point.
- `bootstrap/app.php` creates the Laravel application, loads `routes/web.php`, `routes/api.php`, and `routes/console.php`, exposes the `/up` health endpoint, registers middleware aliases, and redirects unauthenticated admin paths to the admin login route.
- `resources/js/app.js` is intentionally minimal; Alpine is managed by Livewire 4.
- `resources/css/app.css` is the CSS entry point consumed by Vite.
- `artisan` is the CLI entry point.
- `.env` supplies runtime values; `.env.example` documents local defaults.

`routes/admin-api.php` exists but is not loaded by `bootstrap/app.php`; `routes/api.php` is the active source for admin API routes.

## Directory Structure

```text
app/
  Http/
    Controllers/        Web and JSON request orchestration
      Admin/             Administrative web/API controllers
      Auth/              Breeze and admin login controllers
    Middleware/          Admin and role authorization middleware
    Requests/            Form Requests for validation and authorization
  Livewire/               Personal dashboard reactive components
  Models/                 User, task, role, and audit-log Eloquent models
  Providers/              Application service provider
  View/Components/        Blade layout components
bootstrap/                Application bootstrap and cached framework files
config/                   Framework and connection configuration
database/
  factories/              User and task factories
  migrations/             Incremental schema history
  seeders/                 Roles, users, tasks, and application seed data
public/                   Front controller and compiled assets
resources/
  css/                    Tailwind/Vite stylesheet entry point
  js/                     Vite JavaScript entry point
  views/                  Blade layouts, auth, dashboard, admin, and Livewire views
routes/                   Active web, auth, API, and console route definitions
storage/                  Logs, framework cache, and local application files
tests/
  Feature/                HTTP and authorization behavior tests
  Unit/                   Unit tests
```

There are no application `Actions`, `Services`, `Repositories`, `Policies`, `Events`, `Listeners`, `Jobs`, `Notifications`, or domain/module directories. Controllers, Form Requests, Livewire components, and model scopes own the current application behavior.

## Request and Authorization Boundaries

### Browser requests

- `auth` protects signed-in user pages.
- `guest` protects login and registration entry points.
- `role:admin,super_admin` protects administrative user-management and dashboard pages.
- `role:super_admin` protects settings and audit-log pages.
- `role:admin,super_admin,moderator` protects task moderation pages.
- `AdminMiddleware` and `SuperAdminMiddleware` provide additional admin/super-admin checks and suspension handling where directly applied.
- `RoleMiddleware` checks assigned roles through `User::hasRole()`.

### API requests

- `auth:sanctum` protects the personal and administrative JSON surfaces.
- `role` middleware gates administrative roles.
- Rate limits are applied to login, administrative groups, and sensitive actions.
- JSON responses are selected for `/api/*` or requests that expect JSON by the exception configuration.

### Data ownership

Personal task access is scoped to the authenticated user through controller authorization/form requests and Livewire queries. Administrative task operations intentionally operate across users. Admin actions call audit-log creation helpers in the relevant controllers or middleware.

## Active Web Routes

All paths below are registered by `routes/web.php` or `routes/auth.php`. Middleware is summarized from the route definitions.

### Public and authenticated user routes

| Method | Path | Access | Purpose |
|---|---|---|---|
| GET | `/` | Public | Redirect to the appropriate dashboard based on the current user's role |
| GET | `/dashboard` | `auth` | Personal task dashboard |
| GET | `/profile` | `auth` | Profile page |
| PATCH | `/profile` | `auth` | Update profile |
| DELETE | `/profile` | `auth` | Delete account |
| GET/POST | `/login` | `guest` | User login |
| GET/POST | `/register` | `guest` | User registration |
| POST | `/logout` | `auth` | User logout |
| GET/POST | `/forgot-password` | Guest/password flow | Request password reset |
| GET/POST | `/reset-password/{token}` | Guest/password flow | Complete password reset |
| GET | `/verify-email` | `auth` | Email verification notice |
| GET | `/verify-email/{id}/{hash}` | `auth` | Verify email |
| POST | `/email/verification-notification` | `auth` | Resend verification |
| GET/POST | `/confirm-password` | `auth` | Confirm password |
| PUT | `/password` | `auth` | Update password |

### Admin web routes

| Method | Path | Access | Purpose |
|---|---|---|---|
| GET/POST | `/admin/login` | `guest` | Admin login page and submission |
| GET | `/admin/dashboard` | `auth`, admin roles | Admin overview |
| GET | `/admin/stats` | `auth`, admin roles | JSON dashboard statistics |
| GET | `/admin/users` | `auth`, admin roles | User listing |
| GET | `/admin/users/{user}/edit` | `auth`, admin roles | User edit form |
| PUT | `/admin/users/{user}` | `auth`, admin roles | Update user |
| POST | `/admin/users/{user}/suspend` | `auth`, admin roles | Suspend user |
| POST | `/admin/users/{user}/unsuspend` | `auth`, admin roles | Unsuspend user |
| DELETE | `/admin/users/{user}` | `auth`, admin roles | Delete user |
| DELETE | `/admin/users/{user}/role/{role}` | `auth`, admin roles | Remove a role |
| GET/PUT | `/admin/settings` | `auth`, super admin | View/update settings |
| GET | `/admin/audit-logs` | `auth`, super admin | Review audit logs |
| GET | `/admin/audit-logs/export` | `auth`, super admin | Export audit logs |
| GET | `/admin/tasks` | `auth`, moderator/admin roles | Task moderation list |
| DELETE | `/admin/tasks/{task}` | `auth`, moderator/admin roles | Soft-delete a task |
| PATCH | `/admin/tasks/{task}/restore` | `auth`, moderator/admin roles | Restore a task |
| PUT | `/admin/tasks/{task}/status` | `auth`, moderator/admin roles | Change task status |
| PUT | `/admin/tasks/{task}/reassign` | `auth`, moderator/admin roles | Reassign task owner |
| POST | `/admin/tasks/bulk-action` | `auth`, moderator/admin roles | Apply a bulk task action |

## Active API Routes

All API paths are defined in `routes/api.php`. `/api/user` and personal tasks require Sanctum authentication. Administrative paths additionally require the listed role middleware and rate limits.

### Personal API

| Method | Path | Access | Purpose |
|---|---|---|---|
| GET | `/api/user` | `auth:sanctum` | Return the authenticated user |
| GET | `/api/tasks` | `auth:sanctum` | List owned tasks |
| POST | `/api/tasks` | `auth:sanctum` | Create an owned task |
| GET | `/api/tasks/{task}` | `auth:sanctum` | Show an owned task |
| PUT/PATCH | `/api/tasks/{task}` | `auth:sanctum` | Update an owned task |
| DELETE | `/api/tasks/{task}` | `auth:sanctum` | Soft-delete an owned task |

### Admin API

| Method | Path | Access | Purpose |
|---|---|---|---|
| POST | `/api/admin/login` | Login throttle | Issue an admin API token |
| GET/PUT/DELETE | `/api/admin/users[/{user}]` | `admin,super_admin` | List, inspect, update, or delete users |
| POST | `/api/admin/users/{user}/suspend` | `admin,super_admin` | Suspend a user |
| POST | `/api/admin/users/{user}/unsuspend` | `admin,super_admin` | Unsuspend a user |
| POST/DELETE | `/api/admin/users/{user}/roles/{role}` | Admin group; super-admin behavior enforced in controller | Assign/remove a role |
| GET | `/api/admin/analytics/dashboard` | `admin,super_admin` | Dashboard analytics |
| GET | `/api/admin/analytics/users` | `admin,super_admin` | User analytics |
| GET | `/api/admin/analytics/tasks` | `admin,super_admin` | Task analytics |
| GET | `/api/admin/audit-logs` | `super_admin` | List audit logs |
| GET | `/api/admin/audit-logs/{auditLog}` | `super_admin` | Show an audit log |
| GET | `/api/admin/audit-logs/export` | `super_admin` | Export audit logs |
| GET/PUT | `/api/admin/settings` | `super_admin` | Read/update settings payload |
| GET | `/api/admin/tasks` | `moderator,admin,super_admin` | List all tasks |
| GET | `/api/admin/tasks/{task}` | `moderator,admin,super_admin` | Show any task |
| PUT | `/api/admin/tasks/{task}` | `moderator,admin,super_admin` | Reassign a task |
| DELETE | `/api/admin/tasks/{task}` | `moderator,admin,super_admin` | Delete a task |
| POST | `/api/admin/tasks/bulk-action` | `moderator,admin,super_admin` | Apply bulk task actions |

There are no active API routes for `TaskModerationController::apiUpdateStatus()` or `apiRestore()`, despite those methods existing.

## Data Model and Schema

### Users

The users table starts with identity and authentication fields: `id`, `name`, unique `email`, `email_verified_at`, `password`, `remember_token`, and timestamps. Later migrations add `is_admin`, `is_suspended`, `suspended_at`, `suspension_reason`, `last_admin_action_at`, and `dark_mode`.

`User` relates to `tasks`, `roles`, and `auditLogs`. Passwords are hashed through model casts. The model's role lookup primarily uses the `roles` relationship, then falls back to a legacy `is_admin` flag or raw `role` value. No migration creates a `role` column, so the latter fallback is not a supported schema source.

### Tasks

Tasks contain `id`, required `user_id` with cascading deletion, `title`, nullable `description`, `status`, soft-delete timestamp, and timestamps. Status is constrained by application validation and the SQLite schema to `pending`, `in_progress`, or `completed`. `Task` has a `user` relationship, owner/status query scopes, an ownership check, and `SoftDeletes`.

### Roles and assignments

`roles` contains a unique `name`, `description`, `is_system`, and timestamps. `role_user` links users and roles with cascading foreign keys, `assigned_at`, timestamps, and a unique user-role pair. Built-in roles are `user`, `moderator`, `admin`, and `super_admin`.

### Audit logs

`audit_logs` stores nullable `admin_id`, `action`, nullable `model_type` and `model_id`, JSON `changes`, IP address, user agent, and `created_at`. It has indexes for administrator, date, model type, and administrator/date. `AuditLog` exposes recent/admin/model/action scopes and dynamically resolves a model from the `App\\Models` namespace.

### Framework tables

The migration history also creates personal access tokens, cache, jobs, and failed-job support where applicable in the framework migration set. The current environment reports all 12 migrations as run.

## Component Hierarchy

### Personal dashboard

```text
dashboard.blade.php
  layouts.app
  TaskStats
  TaskFilter
  CreateTask
  TaskList
  EditTask
  DarkModeToggle (included by application navigation/layout)
```

- `CreateTask` validates and creates an authenticated user's task.
- `TaskList` loads the user's paginated task list, applies status filtering, deletes tasks, and dispatches an edit event.
- `TaskFilter` validates status selection and dispatches status changes.
- `TaskStats` computes all/pending/in-progress/completed counts.
- `EditTask` loads, updates, and deletes an owned task from a modal.
- `DarkModeToggle` persists the user's preference.
- `TaskManager` is an older combined create/list component and is not referenced by the active dashboard.

### Administrative views

```text
layouts.admin
  admin.dashboard
  admin.users.index
  admin.users.edit
  admin.tasks.index
  admin.audit-logs
  admin.settings
```

Administrative controllers provide dashboard statistics, user management, task moderation, audit-log review/export, settings, analytics, and admin API responses. Authentication and role middleware are shared across these controllers.

### Blade and layout components

`resources/views/layouts` contains the primary app, guest, admin, and navigation layouts. `resources/views/components` contains reusable buttons, forms, cards, badges, dropdowns, inputs, status messages, and layout components. There are two app-layout paths: `layouts/app.blade.php` and `components/layouts/app.blade.php`.

## Configuration and Environment

The `.env.example` defaults are development-oriented:

- `APP_ENV=local`, `APP_DEBUG=true`, and `APP_URL=http://localhost:8000`
- SQLite database
- Database sessions, cache, and queues
- File maintenance mode
- Local filesystem
- Log mailer
- Redis and AWS variables present as optional configuration placeholders
- Vite application name derived from `APP_NAME`

The repository also contains configuration entries for MySQL, MariaDB, PostgreSQL, SQL Server, Redis, S3-compatible storage, and mail transports, but no active external integration was found in the application code.

## Third-Party and Framework Integrations

Present and used:

- Laravel Breeze authentication scaffolding
- Laravel Sanctum token authentication
- Livewire reactive server-rendered UI
- Tailwind CSS and Vite asset pipeline
- Alpine.js package available through the frontend toolchain
- Database drivers, session/cache/queue adapters, and log mailer supplied by Laravel

Not implemented despite configuration or dependency availability:

- Outbound HTTP integrations, webhooks, and external APIs
- Mailables or notification classes
- Queue jobs, events, listeners, or scheduled application work
- Object-storage upload workflows
- Durable admin settings storage
- Separate admin guard or token ability model

## Testing and Verification

The test suite uses PHPUnit with `RefreshDatabase` for feature tests. Existing coverage includes authentication, personal task API ownership, admin access boundaries, suspension, role guardrails, task moderation, and selected audit behavior. Focused verification previously passed `TaskApiTest` and `AdminSystemTest` with 42 tests and 100 assertions.

`tests/Feature/Admin/AdminApiTest.php` contains placeholder assertions for many API concerns, so its test count must not be treated as proof of endpoint behavior. `tests/rbac-matrix.spec.ts` is a Playwright test file, but the repository audit did not establish a configured command or browser-runner workflow for it.

## Technical Debt and Known Issues

### High priority

- The active task list dispatches `open-edit-task-modal`, while `EditTask` listens for `edit-task`; the edit modal does not open from the active edit control.
- The edit modal invokes `deleteTask`, while `EditTask` defines `delete`; modal deletion fails.
- Admin settings are applied with runtime `config()` mutation only. There is no settings table or `config/admin.php`, so changes are not durable.
- `TaskModerationController::show()` and `AuditLogController::show()` reference views/routes that are absent from the current tree.
- `routes/admin-api.php` duplicates active API definitions but is not loaded, creating a misleading second route source.

### Medium priority

- API methods for task status update and restore are unreachable because no active API routes reference them.
- The admin API test file includes many `assertTrue(true)` placeholders.
- A browser RBAC test and the active route policy disagree about whether ordinary admins may access settings.
- User update paths permit direct suspension-field updates that bypass the dedicated suspension-reason workflow.
- Bulk task reassignment allows a nullable target user and may silently perform no reassignment.
- Super-admin role-removal and deletion guardrails use different thresholds; the intended invariant needs one explicit rule.
- `AdminSeeder` sets the legacy `is_admin` flag for moderators even though role relationships are the effective authorization source.
- Authorization has multiple sources: relationship roles, the legacy `is_admin` flag, and an unsupported raw `role` fallback.
- Dashboard statistics are calculated through repeated count/aggregate queries and duplicated admin analytics logic.
- Dynamic model resolution in `AuditLog` is weakly typed and depends on database-provided class names.

### Lower priority

- Two app layout implementations and repeated navigation/SVG markup increase visual maintenance cost.
- Migration history contains both initial task soft-delete support and a later conditional soft-delete migration.
- `Role::seedDefaults()` overlaps with the role seeder.
- Ownership and authorization are distributed across controllers, Form Requests, middleware, and Livewire queries rather than centralized policies.

## Architectural Constraints

- Preserve the separation between personal task flows and admin RBAC flows.
- Keep administrative actions auditable.
- Do not introduce a second authorization source while the role relationship remains canonical.
- Preserve current route behavior unless a change is explicitly intended and covered by feature tests.
- Do not assume files in the repository are active: verify route registration and component references before documenting or extending them.
