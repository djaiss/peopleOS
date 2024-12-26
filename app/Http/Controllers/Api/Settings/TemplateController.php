<?php

namespace App\Http\Controllers\Api\Settings;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenderCollection;
use App\Http\Resources\GenderResource;
use App\Http\Resources\TemplateCollection;
use App\Http\Resources\TemplateResource;
use App\Models\Gender;
use App\Models\Template;
use App\Services\CreateGender;
use App\Services\CreateTemplate;
use App\Services\DestroyGender;
use App\Services\DestroyTemplate;
use App\Services\UpdateGender;
use App\Services\UpdateTemplate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Templates
 *
 * Templates define the structure of a journal entry. As of this writing, the
 * content of a template is defined as a YAML file.
 * The YAML file is interpreted by the application to render the journal entry
 * the day the template is used.
 */
class TemplateController extends Controller
{
    /**
     * Create a template.
     *
     * @bodyParam name string required The name of the template. Max 255 characters. Example: Work day
     * @bodyParam content string required The content of the template which is a YAML file. Example: any valid YAML file
     *
     * @response 201 {
     *  "id": 1,
     *  "object": "template",
     *  "name": "Work day",
     *  "content": "<a YAML file>",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "template".
     * @responseField name The name of the template.
     * @responseField content The content of the template which is a YAML file.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $template = (new CreateTemplate(
            user: Auth::user(),
            name: $validated['name'],
            content: $validated['content'],
        ))->execute();

        return new TemplateResource($template);
    }

    /**
     * Update a template.
     *
     * @urlParam template required The id of the template. Example: 1
     *
     * @bodyParam name string required The name of the template. Max 255 characters. Example: Work day
     * @bodyParam content string required The content of the template which is a YAML file. Example: any valid YAML file
     *
     * @response 200 {
     *  "id": 1,
     *  "object": "template",
     *  "name": "Work day",
     *  "content": "<a YAML file>",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "template".
     * @responseField name The name of the template.
     * @responseField content The content of the template which is a YAML file.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function update(Request $request)
    {
        $id = $request->route()->parameter('template');

        try {
            $template = Template::where('account_id', Auth::user()->account_id)
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(401, 'There is no template with this id in your account.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $template = (new UpdateTemplate(
            user: Auth::user(),
            template: $template,
            name: $validated['name'],
            content: $validated['content'],
        ))->execute();

        return new TemplateResource($template);
    }

    /**
     * Delete a template.
     *
     * @urlParam template required The id of the template. Example: 1
     *
     * @response 200 {
     *  "status": "success"
     * }
     */
    public function destroy(Request $request): JsonResponse
    {
        $id = $request->route()->parameter('template');

        try {
            $template = Template::where('account_id', Auth::user()->account_id)
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(401, 'There is no template with this id in your account.');
        }

        (new DestroyTemplate(
            user: Auth::user(),
            template: $template,
        ))->execute();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * Retrieve a template.
     *
     * @urlParam template required The id of the template. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "object": "template",
     *   "name": "Work day",
     *   "content": "<a YAML file>",
     *   "created_at": 1514764800,
     *   "updated_at": 1514764800
     * }
     * @response 401 {
     *   "message": "There is no template with this id in your account."
     * }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "template".
     * @responseField name The name of the template.
     * @responseField content The content of the template which is a YAML file.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function show(Request $request)
    {
        $id = $request->route()->parameter('template');

        try {
            $template = Template::where('account_id', Auth::user()->account_id)
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(401, 'There is no template with this id in your account.');
        }

        return new TemplateResource($template);
    }

    /**
     * List all templates.
     *
     * This API call returns a paginated collection of templates that contains
     * 15 items per page.
     *
     * @response 200 {"data": [{
     *  "id": 1,
     *  "object": "template",
     *  "name": "Work day",
     *  "content": "<a YAML file>",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }, {
     *  "id": 2,
     *  "object": "template",
     *  "name": "Work day",
     *  "content": "<a YAML file>",
     *  "created_at": 1514764800,
     *  "updated_at": 1514764800,
     * }],
     * "links": {
     *   "first": "http://peopleos.test/api/templates?page=1",
     *   "last": "http://peopleos.test/api/templates?page=1",
     *   "prev": null,
     *   "next": null
     *  },
     *  "meta": {
     *    "current_page": 1,
     *    "from": 1,
     *    "last_page": 1,
     *    "links": [
     *      {
     *        "url": null,
     *        "label": "&laquo; Previous",
     *        "active": false
     *      },
     *      {
     *        "url": "http://peopleos.test/api/templates?page=1",
     *        "label": "1",
     *        "active": true
     *      },
     *      {
     *        "url": null,
     *        "label": "Next &raquo;",
     *        "active": false
     *      }
     *    ],
     *    "path": "http://peopleos.test/api/templates",
     *    "per_page": 15,
     *    "to": 1,
     *    "total": 1
     *  }
     *
     * @responseField id Unique identifier for the object.
     * @responseField object The object type. Always "template".
     * @responseField name The name of the template.
     * @responseField content The content of the template which is a YAML file.
     * @responseField created_at The date the object was created. Represented as a Unix timestamp.
     * @responseField updated_at The date the object was last updated. Represented as a Unix timestamp.
     */
    public function index(Request $request)
    {
        $templates = Auth::user()->account
            ->templates()
            ->paginate();

        return new TemplateCollection($templates);
    }
}
