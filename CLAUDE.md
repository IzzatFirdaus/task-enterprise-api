# Project Context and Commands

## Quick Context

This is a Laravel 13 monolith for private task management and a separate role-protected admin workspace. The local environment has PHP 8.5.8 and Composer 2.10.2. The application uses Blade, Livewire 4, Sanctum, SQLite by default, Tailwind 4, Vite, and PHPUnit.

The personal surface is served from `/dashboard` and `/api/tasks`. The staff surface is served from `/admin/*` and `/api/admin/*`. `routes/api.php` is active; `routes/admin-api.php` is a duplicated, unloaded legacy route file.

## Key Entry Points

- `public/index.php`: HTTP front controller
- `bootstrap/app.php`: route loading, middleware aliases, guest redirects, JSON exception behavior
- `routes/web.php`, `routes/auth.php`: browser and authentication routes
- `routes/api.php`: active JSON routes
- `app/Http/Controllers/TaskController.php`: personal task API
- `app/Http/Controllers/Admin/`: admin web and API controllers
- `app/Livewire/`: active personal dashboard components
- `resources/views/dashboard.blade.php`: personal component composition
- `database/migrations/`: schema history
- `tests/Feature/`: request and authorization behavior coverage

## Directory Map

```text
app/Http/{Controllers,Middleware,Requests}  HTTP orchestration, authorization, validation
app/Livewire                                Personal dashboard components
app/Models                                  User, Task, Role, AuditLog
app/View/Components                         Blade layout components
config/                                     Framework and connection configuration
database/{migrations,factories,seeders}    Persistence history and test/sample data
resources/{views,css,js}                    Server-rendered UI and frontend entry points
routes/                                     Web, auth, API, and console route definitions
tests/{Feature,Unit}                        PHPUnit tests
```

## Setup and Development

```powershell
composer install
Copy-Item .env.example .env
New-Item -ItemType File -Force database/database.sqlite
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run build
php artisan serve
```

The default development URL is `http://127.0.0.1:8000`. The Composer `dev` script is also defined for the project's concurrent development workflow: `composer run dev`.

## Verified Commands

```powershell
php artisan route:list --except-vendor
php artisan migrate:status
php artisan optimize:clear
php artisan test --compact
php artisan test --compact tests/Feature/TaskApiTest.php tests/Feature/Admin/AdminSystemTest.php
vendor/bin/pint --dirty --format agent
npm run build
```

Use `migrate:fresh --seed` only when deliberately resetting local data. The focused baseline currently covers personal task ownership and admin boundaries; the admin API suite contains placeholder assertions and must not be treated as complete endpoint coverage.

## Runtime Defaults

`.env.example` uses local SQLite, database-backed sessions/cache/queues, file maintenance mode, local storage, a log mailer, and `APP_DEBUG=true`. Redis and AWS settings are placeholders. Do not use development credentials or defaults in production.

## Safe Editing Rules

- Read `.ai/rules/index.md` and matching rules before editing covered paths.
- Preserve historical context: never delete files or directories. Archive superseded documentation under `docs/v1-archive/` and repair links.
- Verify whether a route, component, or configuration file is active before relying on it.
- Keep personal task ownership and admin RBAC boundaries intact; audit administrative mutations.
- Prefer existing Laravel patterns and feature tests. Do not add dependencies or speculative feature modules without approval.
