<laravel-boost-guidelines>
## Repository Operating Contract

- **Audit date:** 2026-09-07
- **Companion documents:** [PRD.md](PRD.md), [ARCHITECTURE.md](ARCHITECTURE.md), [ARCHITECTURE-ESSENTIALS.md](ARCHITECTURE-ESSENTIALS.md), [CLAUDE.md](CLAUDE.md).
- **Working tree note:** this repository routinely has unrelated pre-existing uncommitted modifications in the working tree. Always inspect `git status --short` before staging, and only stage and commit files you intentionally changed in the current turn.

This repository is an in-development Laravel 13 task-management application. Keep personal task flows and administrative RBAC flows separate. Do not change feature logic while performing documentation or architecture audits.

### Step-by-step development standard

1. Read `.ai/rules/index.md` and every rule file whose globs cover the path(s) you plan to edit. Search the rules with `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses.
2. Inspect sibling files and active route registration before adding a new implementation. A file that exists is not necessarily active. Verify whether it is referenced.
3. Make the smallest focused change that satisfies the requirement. Do not add dependencies, speculative modules, or new authorization sources without an explicit requirement.
4. Apply conventions: explicit PHP types, curly-braced control structures, descriptive names, Blade components in the existing abstraction level, Livewire for reactive UI.
5. Write or extend the narrowest PHPUnit feature test that covers the change. Cover authentication, ownership, privilege boundaries, validation, audit logging, and failure responses — not just the happy path. Do not use `assertTrue(true)` placeholders.
6. Run the verification baseline below on every behavior change.
7. Update companion docs only when behavior, routes, data model, or conventions actually changed. Do not churn docs for stylistic preference.

### Safe change boundaries

- Read `.ai/rules/index.md` and every matching rule file before editing files under a covered path.
- Inspect sibling files and active route registration before adding a new implementation. A file that exists is not necessarily active.
- Preserve user changes and historical documents. Never delete files or directories during audits; move superseded documentation to `docs/v1-archive/` and repair relative links.
- Prefer the smallest focused change. Do not add dependencies, speculative modules, or new authorization sources without an explicit requirement.
- Treat the role relationship as the current RBAC source while documenting the legacy `is_admin` compatibility behavior as technical debt.
- Keep all administrative mutations auditable and retain owner scoping for personal task reads and writes.

### Local conventions

- Use Laravel controllers, Form Requests, Eloquent models/scopes, Blade, and Livewire components at the existing codebase's current abstraction level.
- Keep web routes in `routes/web.php` and `routes/auth.php`; keep active API routes in `routes/api.php`. Verify route loading through `bootstrap/app.php`. `routes/admin-api.php` is an unloaded duplicate; do not add active routes there without changing bootstrap intentionally.
- Use PHPUnit feature tests for request, authorization, validation, and ownership behavior. Run the narrowest relevant test file after each behavior change.
- Use descriptive names, explicit PHP types, curly-braced control structures, and Pint for modified PHP files.
- Do not treat placeholder assertions as coverage. Add assertions for the observable contract, especially authentication, ownership, privilege boundaries, validation, audit logging, and failure responses.

### Git commit rules

- Do not commit unless the user explicitly asks.
- Before staging, run `git status --short` and `git diff --stat` to confirm only intended files are in the change set. Never commit secrets, credentials, or `.env` values.
- Group changes by intent in one commit. Do not mix unrelated fixes in a feature commit.
- Use Conventional Commits: `feat:`, `fix:`, `refactor:`, `test:`, `docs:`, `chore:`, `perf:`. Imperative, present tense, lowercase summary line; optional body explaining the why.
- Do not amend a commit the user already pushed; create a new commit instead.
- Do not bypass hooks, force-push, or use `-i`/interactive operations on shared history without explicit user approval.

### Boundary constraints

- Do not add new authorization sources (a second `is_admin`-style column, a raw `role` string column, an `abilities` table) without an explicit requirement. Role relationships are canonical.
- Do not introduce external services, queue jobs, notifications, mailables, or background workers without an explicit requirement. The current stack has none of these.
- Do not add new base directories (`app/Actions`, `app/Services`, `app/Repositories`, `app/Policies`, etc.) without an explicit requirement. The current organization is controllers + form requests + Livewire + Eloquent scopes.
- Do not enable new production integrations (S3, Redis, mail transports) until `.env.example` is updated and the related configuration is verified locally.
- Do not describe the development defaults (SQLite, database sessions, log mailer) as production readiness in any document or message.

### Verification baseline

From the repository root, the focused baseline is:

```powershell
php artisan test --compact tests/Feature/TaskApiTest.php tests/Feature/Admin/AdminSystemTest.php
php artisan route:list --except-vendor
php artisan migrate:status
npm run build
vendor/bin/pint --dirty --format agent
```

The full suite currently contains 115 tests with 248 assertions. The focused baseline is the contract for personal task ownership and admin boundaries; the admin API suite (`tests/Feature/Admin/AdminApiTest.php`) contains 37 `assertTrue(true)` placeholders and must not be treated as endpoint coverage.

The application defaults to SQLite, database sessions/cache/queues, and the log mailer. Do not describe those development defaults as production readiness.

=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application running on PHP 8.5. You are an expert with the Laravel ecosystem. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists (settled decisions, non-obvious traps, standing constraints). Framework and package guidelines that only apply to specific paths (testing, frontend, components) also live there, under `.ai/rules/boost` — this is not just recorded decisions, it is load-bearing guidance you have not seen inline. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.
- Record durable rules with `record-rule` so the next agent or teammate inherits them instead of working them out again. Pass a `glob` (e.g. `app/Http/Controllers/**`), a short `title`, and a few-line `note`. Always use `record-rule`, never your native memory or notes tool — native memory is personal and session-scoped; only `.ai/rules` is shared with the team and persists in the repo.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== livewire/core rules ===

# Livewire

- Livewire allows you to build dynamic, reactive interfaces in PHP without writing JavaScript.
- You can use Alpine.js for client-side interactions instead of JavaScript frameworks.
- Keep state server-side so the UI reflects it. Validate and authorize in actions as you would in HTTP requests.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== phpunit/core rules ===

# PHPUnit

- This project uses PHPUnit. Create tests with `php artisan make:test --phpunit {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, naming, structure, dependency isolation, and review.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/phpunit` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.

</laravel-boost-guidelines>

<!-- antislop:start -->
## antislop
For UI, copy, people, mobile layout, or code comments work, load the antislop skill for the task:
- Core filter, always on: `antislop`
- UI / visual: `antislop-ui`
- Copy & text: `antislop-copywriting`
- People: `antislop-human`
- Mobile / responsive: `antislop-layoutmobile`
- Code comments: `antislop-code`
Before starting, ask the user when antislop applies: during the work, or after it is done.
<!-- antislop:end -->
