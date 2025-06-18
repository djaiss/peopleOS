<?php

declare(strict_types=1);

namespace App\Http\Controllers\Journal;

use App\Enums\MoodType;
use App\Http\Controllers\Controller;
use App\Models\Mood;
use App\Services\CreateMood;
use App\Services\DestroyMood;
use App\Services\UpdateMood;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EntryMoodController extends Controller
{
    public function new(Request $request): View
    {
        $day = (int) $request->route()->parameter('day');
        $month = (int) $request->route()->parameter('month');
        $year = (int) $request->route()->parameter('year');

        return view('journal.entry.partials.mood.new', [
            'day' => $day,
            'month' => $month,
            'year' => $year,
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $entry = $request->attributes->get('entry');

        $validated = $request->validate([
            'mood' => ['required', Rule::enum(MoodType::class)],
        ]);

        // find the mood type based on the string
        $moodType = MoodType::from($validated['mood']);

        (new CreateMood(
            user: Auth::user(),
            entry: $entry,
            moodType: $moodType,
        ))->execute();

        return redirect()->route('journal.entry.show', [
            'year' => $entry->year,
            'month' => $entry->month,
            'day' => $entry->day,
        ])->with('status', trans('Mood logged'));
    }

    public function edit(Request $request): View
    {
        $mood = $request->attributes->get('mood');
        $entry = $request->attributes->get('entry');

        return view('journal.entry.partials.mood.edit', [
            'mood' => $mood,
            'year' => $entry->year,
            'month' => $entry->month,
            'day' => $entry->day,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $mood = $request->attributes->get('mood');
        $entry = $request->attributes->get('entry');

        $validated = $request->validate([
            'mood' => ['required', Rule::enum(MoodType::class)],
        ]);

        // find the mood type based on the string
        $moodType = MoodType::from($validated['mood']);

        (new UpdateMood(
            user: Auth::user(),
            mood: $mood,
            moodType: $moodType,
        ))->execute();

        return redirect()->route('journal.entry.show', [
            'year' => $entry->year,
            'month' => $entry->month,
            'day' => $entry->day,
        ])->with('status', trans('Mood updated'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $mood = $request->attributes->get('mood');
        $entry = $request->attributes->get('entry');

        (new DestroyMood(
            user: Auth::user(),
            mood: $mood,
        ))->execute();

        return redirect()->route('journal.entry.show', [
            'year' => $entry->year,
            'month' => $entry->month,
            'day' => $entry->day,
        ])->with('status', trans('Mood deleted'));
    }
}
