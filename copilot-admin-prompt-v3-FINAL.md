# 🔐 COPILOT CHAT: BUILD ADMIN INTERFACE + RBAC SYSTEM
## ⚠️ STRICTEST EXECUTION MODE - COMPLETE ADMIN SYSTEM DELIVERY

**SEND THIS TO COPILOT CHAT IN VS CODE (@workspace context)**

---

## CRITICAL CONTEXT

The current application has:
- ✅ User authentication (Breeze)
- ✅ User task management (Livewire + API)
- ✅ Database with 3 seeded users
- ❌ **NO admin interface** ← BUILD THIS
- ❌ **NO role system** ← BUILD THIS
- ❌ **NO audit logs** ← BUILD THIS

**Your Task:** Build a complete enterprise admin system that runs PARALLEL to the user system (completely separate).

---

## ARCHITECTURE REQUIREMENTS

### 1. Database Layer
- Create `roles` table: id, name, description
- Create `role_user` table: user_id, role_id (pivot)
- Create `audit_logs` table: id, user_id, action, model, model_id, changes, ip, timestamp
- Add `is_admin` boolean to users table (quick access)
- Create `admin_settings` table (for system configuration)

### 2. Roles System
**Built-in Roles:**
- `super_admin` — Full system access, cannot be deleted
- `admin` — User/task management, cannot manage other admins
- `moderator` — Can view/manage tasks, cannot manage users
- `user` — Basic task management (default for new users)

### 3. Authentication Separation
- `/login` → Regular user login (existing)
- `/admin/login` → Admin login (NEW, required)
- Guests see only `/login`
- Admins can be "super users" who access both systems

### 4. Admin Dashboard Sections
- Dashboard overview (stats cards)
- Users management (table + CRUD)
- Tasks management (view all tasks, moderation)
- Analytics (charts, statistics)
- Audit logs (activity history)
- Admin settings (system configuration)

### 5. Admin Middleware
- `role:admin` middleware (check if user has admin role)
- `role:super_admin` middleware (check if super_admin)
- Prevent admins from seeing user data accidentally
- Log all admin actions

### 6. API Separation
- `/api/user/tasks` — User API (existing)
- `/api/admin/users` — Admin API for user management (NEW)
- `/api/admin/tasks` — Admin API for task management (NEW)
- `/api/admin/analytics` — Admin analytics API (NEW)
- `/api/admin/audit-logs` — Audit log retrieval (NEW)

### 7. Audit Trail
- Log every admin action (create, update, delete, suspend)
- Store: admin_id, action, model_type, model_id, before/after changes, ip_address, timestamp
- Audit logs viewable only by super_admins

---

## EXECUTION RULES (MANDATORY - STRICTER THAN BEFORE)

### Rule 1: Zero Tolerance for Incomplete Work
- **NEVER provide:** Partial features, half-implemented logic, TODO comments
- **EVERY feature must be:** Complete, tested (code), production-ready
- **If you cannot complete a feature:** EXPLAIN WHY with technical reasons, do NOT skip it

### Rule 2: Explicit Feature Checklist per Phase
**After EACH phase, provide:**
```
## PHASE [N] COMPLETION CHECKLIST

### Database Changes
- [x] Migration file created: [filename]
- [x] New tables: [table1, table2]
- [x] Indexes added: [index1, index2]
- [x] Relationships seeded: [relationships]

### Backend Code
- [x] Controller created: [filename]
- [x] Middleware created: [filename]
- [x] Routes added: [count]
- [x] Request classes: [count]
- [x] All methods implemented: [methods]

### Frontend Code
- [x] Blade views created: [count]
- [x] Livewire components: [count]
- [x] All routes registered: [routes]

### Tests
- [x] Test file created: [filename]
- [x] Test cases written: [count]

### Status
✅ PHASE [N] COMPLETE - NO DEFECTS
```

### Rule 3: Code Quality Standards
- All methods have docblocks
- All classes have type hints
- No magic numbers (use constants)
- All queries use eager loading
- All responses follow same JSON format
- All error handling is explicit
- All validation is strict

### Rule 4: Security Enforcement
- Admin routes protected by `role:admin` middleware
- Super admin detection prevents deletion of all admins
- Audit logs track every admin action
- IP addresses logged for security
- Rate limiting on sensitive endpoints
- No direct admin access to user passwords

### Rule 5: Database Consistency
- All migrations are reversible (down() method)
- All foreign keys have cascade/restrict rules
- Indexes on frequently queried columns
- Soft deletes for audit trail integrity (optional but recommended)
- Seeds create demo admin accounts

### Rule 6: No Laziness Allowed
- **UNACCEPTABLE:** "You can add this manually"
- **UNACCEPTABLE:** "This can be done later"
- **UNACCEPTABLE:** Stub implementations
- **UNACCEPTABLE:** Partial features
- **REQUIRED:** Complete, copy-paste-ready code

---

## DETAILED PHASE BREAKDOWN

### PHASE 1: DATABASE LAYER (BLOCKING)

**1.1 Create `roles` Migration**
```
File: database/migrations/xxxx_create_roles_table.php
Requirements:
- Table: roles
- Columns: id, name (unique), description, is_system (bool), created_at, updated_at
- Indexes: name
- Built-in roles to seed: super_admin, admin, moderator, user
```

**1.2 Create `role_user` Pivot Migration**
```
File: database/migrations/xxxx_create_role_user_table.php
Requirements:
- Table: role_user
- Columns: id, user_id, role_id, assigned_at
- Foreign keys: CASCADE on delete
- Indexes: user_id, role_id, composite (user_id, role_id)
```

**1.3 Create `audit_logs` Migration**
```
File: database/migrations/xxxx_create_audit_logs_table.php
Requirements:
- Table: audit_logs
- Columns: id, admin_id, action (enum: create, update, delete, suspend), model_type, model_id, changes (JSON), ip_address, user_agent, created_at
- Indexes: admin_id, created_at, model_type
- Foreign key: admin_id → users(id) CASCADE
```

**1.4 Alter `users` Table**
```
File: database/migrations/xxxx_add_admin_columns_to_users_table.php
Requirements:
- Add: is_suspended (bool, default false), suspended_at (nullable timestamp), suspension_reason (nullable text)
- Add: last_admin_action_at (nullable timestamp)
- Indexes: is_suspended
```

**ACTION:** Provide complete migration code for ALL 4 migrations. Provide seeding code for roles.

---

### PHASE 2: MODELS & RELATIONSHIPS

**2.1 Create Role Model**
```
File: app/Models/Role.php
Requirements:
- BelongsToMany relationship to User
- Scopes: isSystem(), notSystem()
- Methods: hasPermission($permission), isSuperAdmin(), isAdmin()
- Constants: SUPER_ADMIN = 'super_admin', ADMIN = 'admin', MODERATOR = 'moderator', USER = 'user'
- Prevent deletion of system roles
```

**2.2 Update User Model**
```
File: app/Models/User.php
Requirements:
- Add BelongsToMany relationship: roles()
- Add methods: 
  - hasRole(string|array $roles): bool
  - hasAnyRole(array $roles): bool
  - hasAllRoles(array $roles): bool
  - isSuperAdmin(): bool
  - isAdmin(): bool
  - canManageUsers(): bool (admin + super_admin)
  - canModerate(): bool (moderator, admin, super_admin)
- Accessors/mutators: is_admin property checks if has admin role
- Relationships: auditLogs() HasMany
```

**2.3 Create AuditLog Model**
```
File: app/Models/AuditLog.php
Requirements:
- BelongsTo User (admin who performed action)
- Methods: getModelAttribute() (returns actual model instance)
- Scopes: recent(), byAdmin($adminId), byModel($modelType), byAction($action)
- Casts: changes as array, created_at as datetime
- Accessors: human_action (display friendly action name)
```

**ACTION:** Provide complete code for Role, updated User, and new AuditLog models with all methods implemented.

---

### PHASE 3: MIDDLEWARE & AUTHORIZATION

**3.1 Create Middleware**
```
File: app/Http/Middleware/AdminMiddleware.php
Requirements:
- Check if user has admin role (isSuperAdmin or isAdmin)
- If not, return 403 or redirect to /login
- Log access attempts in audit_logs
- Check if user is suspended (is_suspended = true)
```

**3.2 Create Role Middleware**
```
File: app/Http/Middleware/RoleMiddleware.php
Requirements:
- Check if user has one of specified roles
- Usage: middleware('role:admin,super_admin')
- Support multiple roles (OR logic)
- Log role check attempts
```

**3.3 Create SuperAdmin Middleware**
```
File: app/Http/Middleware/SuperAdminMiddleware.php
Requirements:
- Check if user is ONLY super_admin
- Protect super_admin-only routes
- Log attempts from non-super-admins
```

**ACTION:** Provide complete middleware code for all 3. Show registration in app/Http/Kernel.php.

---

### PHASE 4: ADMIN REQUEST CLASSES & VALIDATION

**4.1 Create UserManagementRequest**
```
File: app/Http/Requests/Admin/UpdateUserRequest.php
Requirements:
- Validate: email (unique except self), name (required), roles (array of role IDs)
- Prevent: Removing own admin role, deleting last super_admin
- Validate: suspension_reason if is_suspended = true
- Rules:
  - email: 'sometimes|email|unique:users,email,'.$userId
  - roles: 'array|exists:roles,id'
  - is_suspended: 'boolean'
```

**4.2 Create SuspendUserRequest**
```
File: app/Http/Requests/Admin/SuspendUserRequest.php
Requirements:
- Validate: reason (required, max 500)
- Prevent: Suspending last super_admin
- Prevent: Admin suspending another admin (only super_admin can)
```

**4.3 Create AdminSettingsRequest**
```
File: app/Http/Requests/Admin/AdminSettingsRequest.php
Requirements:
- Validate: various system settings
- Only super_admin can update
```

**ACTION:** Provide complete request classes with all validation rules and custom messages.

---

### PHASE 5: ADMIN CONTROLLERS

**5.1 Create AdminController (Dashboard)**
```
File: app/Http/Controllers/Admin/AdminController.php
Methods required:
- dashboard() → Shows stats (user count, task count, recent activity)
- stats() → Return JSON stats for dashboard cards
```

**5.2 Create UserManagementController**
```
File: app/Http/Controllers/Admin/UserManagementController.php
Methods required:
- index() → Paginated list of all users with roles, suspension status
- show($userId) → Single user details + history
- edit($userId) → Form data
- update(UpdateUserRequest $request, $userId) → Update user + log to audit
- suspend(SuspendUserRequest $request, $userId) → Mark as suspended + log
- unsuspend($userId) → Unsuspend + log
- assignRole($userId, $roleId) → Add role + log
- removeRole($userId, $roleId) → Remove role + log
- destroy($userId) → Soft delete (prevent hard delete of super_admins)

All methods must:
- Check authorization (super_admin can do all, admin can't touch other admins)
- Log action to audit_logs
- Return proper JSON responses with status codes
- Include error handling
```

**5.3 Create TaskModerationController**
```
File: app/Http/Controllers/Admin/TaskModerationController.php
Methods required:
- index() → Paginated list of ALL tasks (not just own)
- show($taskId) → Task details with user info
- reassignTask(Request $request, $taskId) → Move task to different user + log
- deleteTask($taskId) → Force delete task + log
- bulkAction(Request $request) → Bulk delete/reassign + log each
```

**5.4 Create AuditLogController**
```
File: app/Http/Controllers/Admin/AuditLogController.php
Methods required:
- index() → Paginated audit logs with filters (by admin, by model, by action, by date range)
- show($logId) → Detailed log entry
- export() → Export as CSV (optional but impressive)
Only super_admin can view.
```

**5.5 Create AdminSettingsController**
```
File: app/Http/Controllers/Admin/AdminSettingsController.php
Methods required:
- edit() → Show settings form
- update() → Update settings + log + cache
Only super_admin can modify.
```

**ACTION:** Provide complete controller code for ALL 5 controllers. Every method fully implemented.

---

### PHASE 6: ADMIN API ROUTES

**File: routes/admin-api.php (NEW)**

Requirements:
```php
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // User Management
    Route::apiResource('users', UserManagementController::class);
    Route::post('users/{user}/suspend', SuspendUserController@store);
    Route::post('users/{user}/unsuspend', SuspendUserController@destroy);
    Route::post('users/{user}/roles/{role}', AssignRoleController@store);
    Route::delete('users/{user}/roles/{role}', AssignRoleController@destroy);

    // Task Moderation
    Route::apiResource('tasks', TaskModerationController::class);
    Route::post('tasks/{task}/reassign', ReassignTaskController@store);
    Route::post('tasks/bulk-action', BulkTaskActionController@store);

    // Audit Logs (super_admin only)
    Route::middleware('role:super_admin')->group(function () {
        Route::apiResource('audit-logs', AuditLogController::class, ['only' => ['index', 'show']]);
        Route::get('audit-logs/export', AuditLogController@export);
    });

    // Settings (super_admin only)
    Route::middleware('role:super_admin')->group(function () {
        Route::apiResource('settings', AdminSettingsController::class, ['only' => ['edit', 'update']]);
    });

    // Analytics
    Route::get('analytics/dashboard', AdminAnalyticsController@dashboard);
    Route::get('analytics/users', AdminAnalyticsController@users);
    Route::get('analytics/tasks', AdminAnalyticsController@tasks);
});

Route::post('admin/login', AdminAuthController@login);  // Allow unauthenticated login
```

**ACTION:** Provide complete routes/admin-api.php file. Also update routes/web.php to include admin routes.

---

### PHASE 7: ADMIN WEB ROUTES & VIEWS

**7.1 Create Admin Layout**
```
File: resources/views/layouts/admin.blade.php
Requirements:
- Separate from user layout
- Admin navbar with: Dashboard, Users, Tasks, Audit Logs, Settings, Logout
- Current admin displayed
- Active route highlighting
- Sidebar navigation
- Include Livewire directives
- Tailwind CSS responsive design
```

**7.2 Create Admin Dashboard View**
```
File: resources/views/admin/dashboard.blade.php
Requirements:
- Stats cards: Total Users, Total Tasks, Suspended Users, Recent Activity
- Charts: Tasks by status (pie), Users activity (line), Task creation trend
- Recent audit logs (last 10)
- Quick actions: Manage Users, Manage Tasks, View Audit Logs
```

**7.3 Create User Management View**
```
File: resources/views/admin/users/index.blade.php
Requirements:
- Table: Email, Name, Roles, Status (Active/Suspended), Last Login, Actions
- Pagination
- Search by email/name
- Filter by role
- Filter by status
- Action buttons: View, Edit, Suspend/Unsuspend, Delete
- Bulk action checkbox
```

**7.4 Create User Edit View**
```
File: resources/views/admin/users/edit.blade.php
Requirements:
- Form: Name, Email, Roles (multi-select with checkboxes), Suspended checkbox, Reason textarea
- Show current roles
- Show suspension history
- Show audit trail for this user
- Prevent editing last super_admin
- Prevent non-super-admin from editing other admins
```

**7.5 Create Task Management View**
```
File: resources/views/admin/tasks/index.blade.php
Requirements:
- Table: User, Title, Status, Created, Actions
- Filter by status, by user
- Search by title
- Action buttons: View, Reassign, Delete
- Bulk actions: Delete, Reassign to user
```

**7.6 Create Audit Logs View**
```
File: resources/views/admin/audit-logs.blade.php
Requirements:
- Table: Admin, Action, Model, Model ID, Changes, IP Address, Timestamp
- Filter by admin, by action, by model type, by date range
- Show/hide details (JSON of changes)
- Export to CSV button
- Only visible to super_admin
```

**7.7 Create Settings View**
```
File: resources/views/admin/settings.blade.php
Requirements:
- Form for system settings (site name, admin email, max users, etc.)
- Only super_admin can edit
- Show when last updated and by whom
```

**ACTION:** Provide complete Blade template code for ALL 7 views. Production-ready HTML + Tailwind CSS.

---

### PHASE 8: ADMIN LOGIN & AUTHENTICATION

**8.1 Create Admin Login Controller**
```
File: app/Http/Controllers/Auth/AdminLoginController.php
Requirements:
- Check if user has admin role
- If not admin, deny login
- Create session/token for admin area
- Redirect to /admin/dashboard
- Log login attempt (audit)
```

**8.2 Create Admin Login View**
```
File: resources/views/auth/admin-login.blade.php
Requirements:
- Separate from user login
- Email + password form
- "Back to user login" link
- Styling consistent with app
```

**8.3 Create Admin Routes**
```
File: routes/web.php additions
Requirements:
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('users', UserManagementController::class);
        // ... other admin routes
    });
});
```

**ACTION:** Provide complete controller, view, and routes. Test that admin-only users cannot access user dashboard and vice versa.

---

### PHASE 9: LIVEWIRE ADMIN COMPONENTS (OPTIONAL)

**9.1 Create UserStats Livewire Component**
```
Component: app/Livewire/Admin/UserStats.php
View: resources/views/livewire/admin/user-stats.blade.php
Requirements:
- Display: Total users, Active users, Suspended users, New users this week
- Refresh every 30 seconds
- Listen to user-related audit events
```

**9.2 Create TaskStats Livewire Component**
```
Component: app/Livewire/Admin/TaskStats.php
View: resources/views/livewire/admin/task-stats.blade.php
Requirements:
- Display: Total tasks, By status (pending, in_progress, completed)
- Refresh on changes
```

**9.3 Create AuditLogViewer Component (Searchable)**
```
Component: app/Livewire/Admin/AuditLogViewer.php
View: resources/views/livewire/admin/audit-log-viewer.blade.php
Requirements:
- Display recent audit logs with pagination
- Search by admin name, action, model
- Filter by date range
- Real-time updates
```

**ACTION:** Provide Livewire components if wanted for interactivity. If not needed, skip this phase.

---

### PHASE 10: ADMIN MIGRATIONS & SEEDING

**10.1 Create Admin Seeder**
```
File: database/seeders/AdminSeeder.php
Requirements:
- Create 1 super_admin user: admin@example.com / password
- Create 1 admin user: admin2@example.com / password
- Create 1 moderator user: moderator@example.com / password
- Assign roles to each
- Create initial admin_settings
- Log creation in audit_logs
```

**10.2 Update DatabaseSeeder**
```
File: database/seeders/DatabaseSeeder.php
Requirements:
- Call TaskSeeder (existing)
- Call AdminSeeder (new)
- Ensure roles are seeded first
```

**ACTION:** Provide complete seeder code. After migration: 6 total users (3 regular + 3 admin/moderator).

---

### PHASE 11: ADMIN API TESTS

**11.1 Create Admin API Test File**
```
File: tests/Feature/Admin/AdminApiTest.php
Requirements:
Test cases (do NOT run, just provide):
- test_super_admin_can_list_all_users
- test_admin_can_list_users_but_not_view_audit_logs
- test_non_admin_cannot_access_admin_api
- test_suspended_user_cannot_access_admin_api
- test_admin_can_suspend_user_and_log_action
- test_admin_cannot_suspend_another_admin (only super_admin)
- test_super_admin_can_view_audit_logs
- test_audit_logs_created_for_admin_actions
- test_task_reassignment_updates_owner_and_logs
- test_bulk_task_deletion_logged_per_task
- test_admin_settings_update_logged
- test_last_super_admin_cannot_be_deleted
```

**ACTION:** Provide complete test file with all test cases. Do NOT run tests.

---

### PHASE 12: DOCUMENTATION

**12.1 Create ADMIN-SETUP.md**
```
File: ADMIN-SETUP.md
Contents:
- Admin system architecture (diagram if possible)
- Database schema (roles, role_user, audit_logs)
- Authentication flow (separate login)
- API endpoints table (all admin routes + methods)
- Admin roles and permissions breakdown
- How to create new roles
- How to audit admin actions
- Security best practices
- Troubleshooting
```

**12.2 Update Main README.md**
```
Additions:
- Admin system overview section
- Link to ADMIN-SETUP.md
- Admin user credentials (test accounts)
- Screenshots or description of admin dashboard
```

**ACTION:** Provide complete markdown files with all documentation.

---

### PHASE 13: DATABASE INTEGRITY & SEED DATA

**13.1 Run Migrations**
```
Terminal commands:
php artisan migrate
php artisan db:seed --class=AdminSeeder
```

**13.2 Verify Database**
```
Database should now have:
- roles table with 4 built-in roles (super_admin, admin, moderator, user)
- role_user relationships (6 users with roles assigned)
- audit_logs entries (for seeding actions)
- users table with is_suspended, suspension_reason columns
- admin_settings table with initial values
```

**ACTION:** Provide exact terminal commands. Provide database verification queries.

---

### PHASE 14: SECURITY HARDENING

**14.1 Add Rate Limiting**
```
Apply to sensitive endpoints:
- /admin/login → 5 attempts per minute
- /api/admin/users → 30 per minute per admin
- /api/admin/users/{id}/suspend → 10 per minute
- Suspension endpoint → prevent self-suspension
```

**14.2 Add CSRF Protection**
```
Ensure all forms have CSRF tokens (Blade/Livewire)
Ensure all admin POST/PUT/DELETE protected by CSRF
```

**14.3 Add IP Logging**
```
Every admin action logs IP address
Enable IP address tracking in audit logs
```

**ACTION:** Update middleware, routes, and controllers with rate limiting. Update audit log model to capture IP.

---

### PHASE 15: FINAL VALIDATION & SIGN-OFF

**15.1 Code Quality**
```
Run:
php artisan pint
php artisan pint --test
```

**15.2 Route Validation**
```
Run:
php artisan route:list --path=admin
php artisan route:list --path=api/admin
```

**15.3 Database Validation**
```
Run:
php artisan schema:show
php artisan tinker:
  > Role::all()
  > User::with('roles')->get()
  > AuditLog::latest()->first()
```

**15.4 Verify Features**
```
✅ Admin login works (/admin/login)
✅ Admin dashboard loads (/admin/dashboard)
✅ User management works (create, read, update, delete, suspend)
✅ Role assignment works
✅ Task moderation works
✅ Audit logs recorded
✅ Super admin only features protected
✅ Regular users cannot access admin area
✅ All API endpoints respond with 200/201/204/403 as appropriate
✅ All validation messages appear
✅ Audit trail captures all actions
```

---

## VERIFICATION MATRIX

### By End of PHASE 15, Verify:

| Feature | Status | Evidence |
|---------|--------|----------|
| Roles table exists | ✅ | `SELECT * FROM roles;` returns 4 rows |
| Role-user relationships | ✅ | `SELECT * FROM role_user;` shows assignments |
| Audit logs table | ✅ | `SELECT * FROM audit_logs;` shows entries |
| Admin middleware | ✅ | Non-admin redirected from /admin |
| Admin login separate | ✅ | /admin/login is different from /login |
| User management API | ✅ | GET /api/admin/users returns user list |
| Task moderation API | ✅ | GET /api/admin/tasks returns all tasks |
| Audit log API | ✅ | GET /api/admin/audit-logs (super_admin only) |
| Role assignment | ✅ | POST /api/admin/users/{id}/roles/{role} works |
| Suspension system | ✅ | User can be suspended, marked, unsuspended |
| Audit trail | ✅ | Every action logged with admin_id, action, changes |
| Admin views | ✅ | Dashboard, users table, task table, audit logs all load |
| Admin navbar | ✅ | Navigation between admin sections works |
| Tests created | ✅ | 11+ test cases in TaskApiTest.php (not run) |
| Documentation | ✅ | ADMIN-SETUP.md complete with diagrams |
| Code quality | ✅ | Pint formatting passes |
| No defects | ✅ | All static diagnostics clean |

---

## DO NOT ACCEPT

❌ "You can add admin later"
❌ Partial controllers with stubbed methods
❌ Migrations without down() methods
❌ Views without styling
❌ Tests without assertions
❌ API without error handling
❌ Seeding without audit log entries
❌ Admin access for regular users
❌ Skip any of the 15 phases
❌ Routes without middleware
❌ Controllers without docblocks
❌ Any TODO comments in code
❌ Incomplete table structures

---

## DO PROVIDE

✅ Complete, working admin system
✅ All 5 controllers with full CRUD
✅ All 7 Blade views production-ready
✅ All migrations with down() methods
✅ All seeders with demo accounts
✅ All routes with proper middleware
✅ All API endpoints tested (code only)
✅ Comprehensive audit trail
✅ Role-based access control enforced
✅ Security hardening applied
✅ Documentation complete
✅ Zero TODO comments
✅ PSR-12 formatting applied

---

## SIGN-OFF REQUIREMENTS

After each major phase (1, 5, 10, 15), provide:

```
## PHASE [N] SIGN-OFF

✅ [Feature 1] — Complete and tested (code)
✅ [Feature 2] — Complete and tested (code)
✅ [Feature 3] — Complete and tested (code)

### Database Changes
- Tables: [table1, table2]
- Migrations: [migration1, migration2]
- Seeded data: [records]

### Code Changes
- Files created: [count]
- Files modified: [count]
- Lines of code: [count]
- Defects remaining: [0]

### Status
🟢 READY TO PROCEED TO PHASE [N+1]
```

---

## STARTING NOW

**Begin with PHASE 1.**

Provide complete migration code for:
1. roles table
2. role_user pivot table  
3. audit_logs table
4. users table alterations

**Include:**
- Complete migration code (up + down methods)
- Foreign key definitions
- Index definitions
- Seeding code for built-in roles

**Then proceed sequentially through all 15 phases without skipping.**

---

**CRITICAL:** This is an enterprise admin system. Completeness and security are non-negotiable. Every method, every route, every view must be production-ready. No partial work. No shortcuts.

**If you cannot complete a feature due to technical limitations, EXPLAIN the limitation. Do not skip it silently.**

---

**Status: READY FOR EXECUTION**

Proceed with PHASE 1 audit and database layer implementation.
