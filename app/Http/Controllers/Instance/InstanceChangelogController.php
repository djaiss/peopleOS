<?php

declare(strict_types=1);

namespace App\Http\Controllers\Instance;

use App\Http\Controllers\Controller;
use App\Models\Changelog;
use App\Services\CreateChangelog;
use App\Services\DestroyChangelog;
use App\Services\UpdateChangelog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InstanceChangelogController extends Controller
{
    public function index(): View
    {
        $changelogs = Changelog::orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        return view('instance.changelogs.index', [
            'changelogs' => $changelogs,
        ]);
    }

    public function new(): View
    {
        return view('instance.changelogs.new');
    }

    public function create(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request, true);

        (new CreateChangelog(
            pullRequestUrl: $validated['pull_request_url'],
            title: $validated['title'],
            description: $validated['description'],
            slug: $validated['slug'] ?? Str::slug($validated['title']),
            publishedAt: $validated['published_at'] ?? null,
        ))->execute();

        return redirect()->route('instance.changelog.index')
            ->with('status', __('Changes saved'));
    }

    public function edit(int $changelog): View
    {
        $changelogModel = Changelog::findOrFail($changelog);
        return view('instance.changelogs.edit', [
            'changelog' => $changelogModel,
        ]);
    }

    public function update(Request $request, int $changelog): RedirectResponse
    {
        $validated = $this->validateRequest($request, false, $changelog);

        (new UpdateChangelog(
            id: $changelog,
            pullRequestUrl: $validated['pull_request_url'] ?? null,
            title: $validated['title'] ?? null,
            description: $validated['description'] ?? null,
            slug: $validated['slug'] ?? null,
            publishedAt: $validated['published_at'] ?? null,
        ))->execute();

        return redirect()->route('instance.changelog.index')
            ->with('status', __('Changes saved'));
    }

    public function destroy(int $changelog): RedirectResponse
    {
        (new DestroyChangelog(id: $changelog))->execute();

        return redirect()->route('instance.changelog.index')
            ->with('status', __('Changes saved'));
    }

    private function validateRequest(Request $request, bool $creating = true, ?int $id = null): array
    {
        $uniquePull = 'unique:changelogs,pull_request_url';
        $uniqueSlug = 'unique:changelogs,slug';
        if (! $creating && $id !== null) {
            $uniquePull .= ',' . $id;
            $uniqueSlug .= ',' . $id;
        }

        return $request->validate([
            'pull_request_url' => ['required', 'url', $uniquePull],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'slug' => ['nullable', 'string', 'max:255', $uniqueSlug],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}
