<?php

namespace App\Http\Controllers\Api\Vaults;

use App\Http\Controllers\Controller;
use App\Http\Resources\JournalCollection;
use App\Http\Resources\JournalResource;
use App\Models\Journal;
use App\Services\CreateJournal;
use App\Services\DestroyJournal;
use App\Services\UpdateJournal;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Journals
 *
 * Journals are used to track daily entries. Each journal belongs
 * to a vault and can contain multiple days of entries. A day is created when
 * there is no entry for the current day. A day will follow a template.
 */
class JournalController extends Controller
{
    /**
     * Create a journal.
     *
     * @urlParam vault required The id of the vault. Example: 1
     *
     * @bodyParam name string required The name of the journal. Example: Daily journal
     *
     * @response 201 {
     *  "data": {
     *   "id": 1,
     *   "object": "journal",
     *   "vault": {
     *     "id": 1,
     *     "name": "Personal"
     *   },
     *   "name": "Daily journal",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     *  }
     * }
     */
    public function create(Request $request)
    {
        $vault = $request->attributes->get('vault');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $journal = (new CreateJournal(
            user: Auth::user(),
            vault: $vault,
            name: $validated['name'],
        ))->execute();

        return new JournalResource($journal);
    }

    /**
     * Update a journal.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam journal required The id of the journal. Example: 1
     *
     * @bodyParam name string required The name of the journal. Example: Updated journal
     *
     * @response 200 {
     *  "data": {
     *   "id": 1,
     *   "object": "journal",
     *   "vault": {
     *     "id": 1,
     *     "name": "Personal"
     *   },
     *   "name": "Updated journal",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     *  }
     * }
     */
    public function update(Request $request)
    {
        $vault = $request->attributes->get('vault');
        $journal = $request->route()->parameter('journal');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $journal = Journal::where('vault_id', $vault->id)
                ->findOrFail($journal);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        $journal = (new UpdateJournal(
            user: Auth::user(),
            journal: $journal,
            name: $validated['name'],
        ))->execute();

        return new JournalResource($journal);
    }

    /**
     * Delete a journal.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam journal required The id of the journal. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request): JsonResponse
    {
        $vault = $request->attributes->get('vault');
        $journal = $request->route()->parameter('journal');

        try {
            $journal = Journal::where('vault_id', $vault->id)
                ->findOrFail($journal);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        (new DestroyJournal(
            user: Auth::user(),
            journal: $journal,
        ))->execute();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * Get a specific journal.
     *
     * @urlParam vault required The id of the vault. Example: 1
     * @urlParam journal required The id of the journal. Example: 1
     *
     * @response 200 {
     *  "data": {
     *   "id": 1,
     *   "object": "journal",
     *   "vault": {
     *     "id": 1,
     *     "name": "Personal"
     *   },
     *   "name": "Daily journal",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     *  }
     * }
     */
    public function show(Request $request)
    {
        $vault = $request->attributes->get('vault');
        $journal = $request->route()->parameter('journal');

        try {
            $journal = Journal::where('vault_id', $vault->id)
                ->findOrFail($journal);
        } catch (ModelNotFoundException) {
            abort(401);
        }

        return new JournalResource($journal);
    }

    /**
     * List all journals.
     *
     * This API call returns a paginated collection of journals.
     *
     * @urlParam vault required The id of the vault. Example: 1
     *
     * @response 200 {
     *  "data": [{
     *   "id": 1,
     *   "object": "journal",
     *   "vault": {
     *     "id": 1,
     *     "name": "Personal"
     *   },
     *   "name": "Daily journal",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     *  }],
     *  "links": {
     *   "first": "http://url/api/vaults/1/journals?page=1",
     *   "last": "http://url/api/vaults/1/journals?page=1",
     *   "prev": null,
     *   "next": null
     *  },
     *  "meta": {
     *   "current_page": 1,
     *   "last_page": 1,
     *   "total": 1
     *  }
     * }
     */
    public function index(Request $request)
    {
        $vault = $request->attributes->get('vault');

        $journals = $vault->journals()
            ->with('vault')
            ->paginate();

        return new JournalCollection($journals);
    }
}
