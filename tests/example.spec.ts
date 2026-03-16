import { test, expect } from '@playwright/test';

test('has title', async ({ page }) => {
  await page.goto('https://vimbsplumbing.co.za/');

  // Expect a title "to contain" a substring.
  await expect(page).toHaveTitle(/Vimbs Plumbing and Projects/);
});

test('get started link', async ({ page }) => {
  await page.goto('https://vimbsplumbing.co.za/');

  // Click the get started link.
  await page.getByRole('link', { name: 'Get started' }).click();

  // Expects page to have a heading with the name of Installation.
  await expect(page.getByRole('heading', { name: 'Installation' })).toBeVisible();
});
