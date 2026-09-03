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

    public function terms(): View
    {
        return view('public.terms');
    }

    public function sitemap(): Response
    {
        $urls = collect([
            route('about'),
            route('capabilities'),
            route('blog.index'),
            route('terms'),
            route('login'),
            route('register'),
        ])->merge(collect(array_keys(self::CAPABILITIES))->map(fn (string $slug): string => route('capabilities.show', $slug)))
            ->merge(collect($this->posts())->map(fn (array $post): string => route('blog.show', $post['slug'])));

        $xml = '<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls->unique() as $url) {
            $xml .= '<url><loc>'.e($url).'</loc></url>';
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function verification(): Response
    {
        abort_if(config('app.seo.google_verification') === null, 404);

        return response('google-site-verification: '.config('app.seo.google_verification'));
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
