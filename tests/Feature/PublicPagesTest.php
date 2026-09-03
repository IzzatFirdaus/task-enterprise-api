<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    public function test_public_information_pages_render_with_canonical_metadata(): void
    {
        foreach (['/about', '/capabilities', '/capabilities/task-capture', '/blog', '/blog/private-by-default', '/terms'] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('<link rel="canonical" href="'.url($path).'">', false);
        }
    }

    public function test_sitemap_contains_public_pages_but_excludes_private_surfaces(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('/about', false)
            ->assertSee('/blog/private-by-default', false)
            ->assertDontSee('/dashboard', false)
            ->assertDontSee('/admin/', false)
            ->assertDontSee('/api/', false);
    }

    public function test_google_verification_route_is_not_available_without_configured_token(): void
    {
        $this->get('/google-site-verification.html')->assertNotFound();
    }

    public function test_google_verification_route_returns_configured_token(): void
    {
        config(['app.seo.google_verification' => 'verification-token']);

        $this->get('/google-site-verification.html')
            ->assertOk()
            ->assertSee('google-site-verification: verification-token', false);
    }
}
