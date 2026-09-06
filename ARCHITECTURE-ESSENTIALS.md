# Architecture Essentials

- **Audit date:** 2026-09-07
- **Companion document:** [ARCHITECTURE.md](ARCHITECTURE.md). This file is the quick-reference, not the source of truth.

## What This Is

A Laravel 13 monolith for private personal task management plus a role-protected administrative governance surface. PHP 8.5 is installed locally. The browser UI uses Blade and Livewire 4; JSON APIs use Laravel Sanctum; the default local database is SQLite.

## Core Data

- `users`: identity/authentication plus legacy `is_admin` (compatibility only), suspension fields, `last_admin_action_at`, and `dark_mode`.
- `tasks`: required `user_id`, title, nullable description, status (`pending`, `in_progress`, `completed`), soft deletes, timestamps.
- `roles`: unique role name, description, system flag. Built-ins: `user`, `moderator`, `admin`, `super_admin`.
- `role_user`: user-role pivot with unique pair, assignment timestamp, and foreign keys.
- `audit_logs`: admin actor, action, optional model type/id, JSON before/after changes, IP, user agent, created timestamp.
- Framework tables: sessions, cache, jobs, personal access tokens, and migration metadata.

Canonical relationships: `User hasMany Task`, `User belongsToMany Role`, `User hasMany AuditLog`; `Task belongsTo User`; `AuditLog belongsTo User` as `admin`.

## Primary Entry Points

- `bootstrap/app.php`: application bootstrap, active route files, middleware aliases, guest redirects, JSON exception selection.
- `routes/web.php` and `routes/auth.php`: browser dashboard, auth, profile, and admin routes.
- `routes/api.php`: the only loaded API route source. `routes/admin-api.php` is an unloaded duplicate retained for traceability.
- `app/Http/Controllers/TaskController.php`: personal task API.
- `app/Http/Controllers/Admin/*`: admin dashboard, users, tasks, analytics, audit, and settings.
- `app/Livewire/{CreateTask,EditTask,TaskFilter,TaskList,TaskStats,DarkModeToggle}.php`: active dashboard components. `TaskManager.php` is a stale combined component; do not use it for new work.
- `resources/views/dashboard.blade.php`: active personal component composition.

## Primary Routes

### Personal browser and API

- `GET /dashboard`, `GET/PATCH/DELETE /profile`
- `GET/POST /login`, `GET/POST /register`, auth recovery and verification routes
- `GET/POST /api/tasks`, `GET/PUT/PATCH/DELETE /api/tasks/{task}` with `auth:sanctum`
- `GET /api/user` with `auth:sanctum`

### Admin browser

- `GET/POST /admin/login`
- `/admin/dashboard`, `/admin/stats`, `/admin/users*`
- `/admin/tasks`, task delete/restore/status/reassign/bulk-action
- `/admin/audit-logs*` and `/admin/settings` for `super_admin`

### Admin API

- `POST /api/admin/login`
- `/api/admin/users*`, `/api/admin/analytics/*` for `admin` and `super_admin`
- `/api/admin/tasks*` for `moderator`, `admin`, and `super_admin`
- `/api/admin/audit-logs*` and `/api/admin/settings` for `super_admin`

`routes/admin-api.php` duplicates API definitions but is not loaded. Do not add active routes there without changing bootstrap intentionally.

## Critical Constraints

- Personal task reads/writes must remain owner-scoped.
- Admin authorization is role-based and must remain separate from personal task flows.
- Admin actions must create audit records.
- Suspended accounts cannot use protected admin capabilities.
- Guardrails must preserve a usable super-admin account.
- The session admin login is not a separate guard; role middleware supplies the boundary.
- The `role` relationship is the canonical authorization source. The `is_admin` column is compatibility-only; do not add new authorization logic that depends on it.
- Local sessions, cache, and queues use the database; mail uses the log driver.
- No external service integration, notification workflow, queue job, or durable admin settings store is currently implemented.

## Stress-Test Analysis

### Brittle under load

- The personal dashboard and `TaskStats` issue multiple count/list queries per render; growth in task volume and Livewire refresh frequency will amplify database load.
- Admin dashboards and analytics repeat aggregate work instead of sharing a query or cached read model.
- Admin task and user lists paginate, but several bulk operations and audit exports can still process large sets in one request.
- Database-backed sessions, cache, and queues are suitable for local development but require operational sizing and cleanup under production load.
- SQLite is the default and has limited write concurrency for simultaneous Livewire/admin mutations.

### Missing error handling or coverage

- The active edit event name and modal delete method do not match, so the main edit/delete UI failure is not covered by a browser-level test.
- Missing referenced views for task detail and audit-log detail can become runtime view errors if those controller methods are routed later.
- The admin API test file (`tests/Feature/Admin/AdminApiTest.php`) holds 37 `assertTrue(true)` placeholders, leaving endpoint authorization, validation, throttling, response shape, audit creation, and settings persistence weakly verified.
- Bulk reassignment accepts a nullable target and may silently do nothing.
- Direct user updates can bypass the dedicated suspension-reason path.
- Admin settings report success despite being runtime-only and non-persistent.
- Role-source fallbacks and super-admin guardrail thresholds lack focused invariant tests.
- API task status and restore behavior has controller code but no active endpoint coverage because the routes are absent.

### Over-engineered or unnecessarily complex

- The duplicated `routes/admin-api.php` route tree adds a second apparent API boundary without being active.
- `TaskManager` duplicates the decomposed Livewire dashboard and is stale.
- Role authorization carries relationship, legacy flag, and unsupported-column fallbacks simultaneously.
- Controller-level audit helpers and repeated analytics queries duplicate cross-cutting behavior without a single service or policy boundary.
- Both `Role::seedDefaults()` and a role seeder encode the same default-role setup.
- The Breeze-style anonymous-component layout, the default navigation layout, and the application-logo component were archived on 2026-09-07 because no view referenced them after the consolidated `layouts/app.blade.php` became canonical. The `welcome.blade.php` scaffold and an empty placeholder `favicon.ico` were archived at the same time.

## First-Fix Priorities

1. Repair and browser-test the active Livewire edit modal.
2. Make settings persistence behavior explicit and test it.
3. Remove or clearly quarantine duplicate/stale route and component sources.
4. Replace placeholder admin API tests with behavior assertions.
5. Consolidate authorization sources and document one super-admin invariant.

## Change Hygiene

- Before editing a file under a `paths:` glob in `.ai/rules/`, read `.ai/rules/index.md` and the matching rule file.
- Before relying on a file in the tree, verify it is actually referenced (route, view, controller, or component). Files exist that are not active.
- Keep personal task ownership and admin RBAC boundaries intact on every change.
- Run `vendor/bin/pint --dirty --format agent` on every PHP change.
- Run the focused test baseline (`php artisan test --compact tests/Feature/TaskApiTest.php tests/Feature/Admin/AdminSystemTest.php`) on every behavior change.
- Run `npm run build` after frontend changes to confirm the asset manifest is current.
