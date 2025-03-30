<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Journal;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntryResource;
use App\Services\CreateOrRetrieveEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EntryController extends Controller
{
    public function show(Request $request): JsonResource
    {
        $journal = $request->attributes->get('journal');
        $day = (int) $request->route()->parameter('day');
        $month = (int) $request->route()->parameter('month');
        $year = (int) $request->route()->parameter('year');

        $entry = (new CreateOrRetrieveEntry(
            user: Auth::user(),
            journal: $journal,
            day: $day,
            month: $month,
            year: $year,
        ))->execute();

        return new EntryResource($entry);
    }
}
