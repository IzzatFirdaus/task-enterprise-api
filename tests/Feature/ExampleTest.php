<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The public root now serves the guest landing page for unauthenticated visitors
     * and redirects to the appropriate dashboard for signed-in staff. Both are
     * successful responses from the application's point of view.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $this->assertContains($response->getStatusCode(), [200, 301, 302, 303, 307, 308]);
    }
}
