<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    private const CAPABILITIES = [
        'task-capture' => [
            'title' => 'Task capture',
            'summary' => 'Capture the next piece of work quickly, with a clear title, description, and status.',
            'details' => 'Enterprise Tasks keeps task creation deliberately small. Add the work, give it enough context, and choose the state that reflects where it stands.',
        ],
        'progress-tracking' => [
            'title' => 'Progress tracking',
            'summary' => 'See pending, active, and completed work in one focused personal queue.',
            'details' => 'Status filters and summary counts make it easy to answer the operational question that matters most: what needs attention next?',
        ],
        'secure-apis' => [
            'title' => 'Secure APIs',
            'summary' => 'Build integrations against authenticated task endpoints with ownership enforced at the request boundary.',
            'details' => 'Sanctum-protected endpoints expose task operations while keeping personal task reads and writes scoped to the authenticated owner.',
        ],
        'administrative-governance' => [
            'title' => 'Administrative governance',
            'summary' => 'Give authorized staff a separate workspace for moderation, RBAC, and audit review.',
            'details' => 'Role-aware admin routes, suspension controls, moderation tools, and audit records keep operational oversight distinct from personal task work.',
        ],
    ];

    public function about(): View
    {
        return view('public.about');
    }

    public function capabilities(): View
    {
        return view('public.capabilities', ['capabilities' => self::CAPABILITIES]);
    }

    public function capability(string $capability): View
    {
        abort_unless(isset(self::CAPABILITIES[$capability]), 404);

        return view('public.capability', [
            'capability' => self::CAPABILITIES[$capability],
            'slug' => $capability,
        ]);
    }

    public function blog(): View
    {
        return view('public.blog.index', ['posts' => $this->posts()]);
    }

    public function post(string $post): View
    {
        $article = collect($this->posts())->firstWhere('slug', $post);
        abort_unless($article !== null, 404);

        return view('public.blog.show', ['post' => $article]);
    }

    public function faq(): View
    {
        return view('public.faq');
    }

    public function terms(): View
    {
        return view('public.terms');
    }

    public function privacy(): View
    {
        return view('public.privacy');
    }

    public function llms(): Response
    {
        $lines = [
            '# Enterprise Tasks',
            'Source: '.url('/'),
            '',
            'Enterprise Tasks is a personal task management application with administrative governance.',
            '',
            '## Public pages',
            '- Home: '.url('/'),
            '- About: '.route('about'),
            '- Capabilities: '.route('capabilities'),
            '- FAQ: '.route('faq'),
            '- Terms of Service: '.route('terms'),
            '- Privacy Policy: '.route('privacy'),
            '',
            '## Data collected',
            'The application stores: name, email, password hash, role assignments, task content, and administrative audit logs.',
            'No advertising cookies are used. Only essential session and preference storage.',
            '',
            '## Legal',
            'For terms of service, see: '.route('terms'),
            'For privacy policy, see: '.route('privacy'),
        ];

        return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function cookiePolicy(): Response
    {
        return response()->view('public.cookie-policy');
    }

    public function sitemap(): Response
    {
        $entries = [
            ['loc' => url('/'), 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => route('about'), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => route('faq'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => route('capabilities'), 'changefreq' => 'monthly', 'priority' => '0.8'],
            ['loc' => route('blog.index'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => route('terms'), 'changefreq' => 'yearly', 'priority' => '0.3'],
            ['loc' => route('privacy'), 'changefreq' => 'yearly', 'priority' => '0.3'],
        ];

        foreach (array_keys(self::CAPABILITIES) as $slug) {
            $entries[] = [
                'loc' => route('capabilities.show', $slug),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        foreach ($this->posts() as $post) {
            $entries[] = [
                'loc' => route('blog.show', $post['slug']),
                'lastmod' => $this->sitemapDate($post['date'] ?? null),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($entries as $entry) {
            $xml .= '<url>';
            $xml .= '<loc>'.e($entry['loc']).'</loc>';
            if (! empty($entry['lastmod'])) {
                $xml .= '<lastmod>'.e($entry['lastmod']).'</lastmod>';
            }
            $xml .= '<changefreq>'.e($entry['changefreq']).'</changefreq>';
            $xml .= '<priority>'.e($entry['priority']).'</priority>';
            $xml .= '</url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function verification(): Response
    {
        abort_if(config('app.seo.google_verification') === null, 404);

        return response('google-site-verification: '.config('app.seo.google_verification'));
    }

    private function sitemapDate(mixed $value): ?string
    {
        if (! is_string($value) || $value === '') {
            return null;
        }

        $timestamp = strtotime($value);

        return $timestamp === false ? null : gmdate('Y-m-d', $timestamp);
    }

    /** @return array<int, array{slug: string, title: string, description: string, date: string, body: string}> */
    private function posts(): array
    {
        return collect(File::files(base_path('docs/blog')))
            ->filter(fn (\SplFileInfo $file): bool => $file->getExtension() === 'md')
            ->map(function (\SplFileInfo $file): array {
                $contents = File::get($file->getPathname());
                preg_match('/\\A---\\s*(.*?)\\s*---\\s*(.*)\\z/s', $contents, $matches);
                $metadata = collect(preg_split('/\\R/', $matches[1] ?? ''))
                    ->mapWithKeys(function (string $line): array {
                        [$key, $value] = array_pad(explode(':', $line, 2), 2, '');

                        return [trim($key) => trim($value, " \\\"'")];
                    })->all();

                return [
                    'slug' => Str::before($file->getFilename(), '.md'),
                    'title' => $metadata['title'] ?? 'Untitled article',
                    'description' => $metadata['description'] ?? '',
                    'date' => $metadata['date'] ?? now()->toDateString(),
                    'body' => trim($matches[2] ?? ''),
                ];
            })->sortByDesc('date')->values()->all();
    }
}
