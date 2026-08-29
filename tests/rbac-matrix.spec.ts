import { test, expect, Page } from '@playwright/test';

const BASE_URL = 'http://127.0.0.1:8000';

// Account fixtures seeded by AdminSeeder & TaskSeeder
const ACCOUNTS = {
  superAdmin:  { email: 'admin@example.com',     password: 'password', role: 'super_admin' },
  admin:       { email: 'admin2@example.com',    password: 'password', role: 'admin' },
  moderator:   { email: 'moderator@example.com', password: 'password', role: 'moderator' },
  regularUser: { email: 'alex@example.com',      password: 'password', role: 'user' },
};

// Helper function to authenticate users via web session
async function loginAs(page: Page, email: string, pass: string, isElevated: boolean = false) {
  const loginPath = isElevated ? '/admin/login' : '/login';
  await page.goto(`${BASE_URL}${loginPath}`);
  
  await page.fill('input[name="email"]', email);
  await page.fill('input[name="password"]', pass);
  await page.click('button[type="submit"]');
  await page.waitForLoadState('networkidle');
}

// Helper function to perform logout
async function logout(page: Page) {
  await page.goto(`${BASE_URL}/dashboard`);
  await page.locator('form[action*="/logout"]').first().evaluate((form) => {
    (form as HTMLFormElement).submit();
  });
  await page.waitForLoadState('networkidle');
}

test.describe('RBAC Boundary Isolation & Session Matrix', () => {

  test('Scenario 1: Regular User - Access Allowed vs Blocked Boundaries', async ({ page }) => {
    await loginAs(page, ACCOUNTS.regularUser.email, ACCOUNTS.regularUser.password);

    // 1. Allowed routes
    await page.goto(`${BASE_URL}/dashboard`);
    expect(page.url()).toContain('/dashboard');

    await page.goto(`${BASE_URL}/profile`);
    expect(page.url()).toContain('/profile');

    // 2. Blocked Admin Routes (Expect 403 Forbidden or Redirect)
    const blockedRoutes = [
      '/admin/dashboard',
      '/admin/tasks',
      '/admin/users',
      '/admin/settings',
      '/admin/audit-logs'
    ];

    for (const route of blockedRoutes) {
      const response = await page.goto(`${BASE_URL}${route}`);
      const status = response?.status();
      expect([403, 302, 404]).toContain(status);
      if (status === 302) {
        expect(page.url()).not.toContain(route);
      }
    }

    // 3. Clean Session Termination
    await logout(page);
    await page.goto(`${BASE_URL}/dashboard`);
    expect(page.url()).toContain('/login');
  });

  test('Scenario 2: Moderator - Allowed Tasks, Blocked Admin/SuperAdmin Routes', async ({ page }) => {
    await loginAs(page, ACCOUNTS.moderator.email, ACCOUNTS.moderator.password, true);

    // 1. Allowed Moderate Route
    const tasksRes = await page.goto(`${BASE_URL}/admin/tasks`);
    expect([200, 304]).toContain(tasksRes?.status());

    // 2. Blocked Admin & SuperAdmin Routes
    const forbiddenRoutes = [
      '/admin/dashboard',
      '/admin/users',
      '/admin/settings',
      '/admin/audit-logs'
    ];

    for (const route of forbiddenRoutes) {
      const response = await page.goto(`${BASE_URL}${route}`);
      expect([403, 302]).toContain(response?.status());
    }

    await logout(page);
  });

  test('Scenario 3: Admin Role - User/Task/Settings Access, Blocked SuperAdmin Audit Logs', async ({ page }) => {
    await loginAs(page, ACCOUNTS.admin.email, ACCOUNTS.admin.password, true);

    // 1. Verify Allowed Admin Views
    const allowedAdminRoutes = [
      '/admin/dashboard',
      '/admin/stats',
      '/admin/users',
      '/admin/tasks',
      '/admin/settings'
    ];

    for (const route of allowedAdminRoutes) {
      const res = await page.goto(`${BASE_URL}${route}`);
      expect([200, 304]).toContain(res?.status());
    }

    // Assert UI Element rendered correctly on Dashboard view
    await page.goto(`${BASE_URL}/admin/dashboard`);
    await expect(page.locator('h1')).toHaveText(/Admin dashboard/i);

    // 2. Blocked SuperAdmin Exclusive Routes
    const superAdminRoutes = [
      '/admin/audit-logs',
      '/admin/audit-logs/export'
    ];

    for (const route of superAdminRoutes) {
      const res = await page.goto(`${BASE_URL}${route}`);
      expect([403, 302]).toContain(res?.status());
    }

    await logout(page);
  });

  test('Scenario 4: Super Admin - Unrestricted System Access', async ({ page }) => {
    await loginAs(page, ACCOUNTS.superAdmin.email, ACCOUNTS.superAdmin.password, true);

    // 1. Full Audit Access & CSV Export Link Verification
    await page.goto(`${BASE_URL}/admin/audit-logs`);
    await expect(page.locator('h1')).toHaveText(/Audit logs/i);
    await expect(page.locator('a[href*="admin/audit-logs/export"]')).toBeVisible();

    // 2. System Settings Form Verification
    await page.goto(`${BASE_URL}/admin/settings`);
    await expect(page.locator('h1')).toHaveText(/System settings/i);
    await expect(page.getByRole('button', { name: 'Save settings' })).toBeVisible();

    await logout(page);
  });

  test('Scenario 5: API RBAC Route Guards (Sanctum Tokens)', async ({ request }) => {
    // Attempting API call without auth header -> 401 Unauthorized
    const unauthRes = await request.get(`${BASE_URL}/api/admin/users`, {
      headers: { 'Accept': 'application/json' }
    });
    expect(unauthRes.status()).toBe(401);
  });
});