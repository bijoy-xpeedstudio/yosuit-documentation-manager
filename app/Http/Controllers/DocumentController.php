<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use App\Models\Favourite;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request_time = date('y-m-d h:i:s');
        try {
            $data = Document::with('cid.subFolder', 'addedBy', 'tags')->paginate(16);
            if ($data) {
                return ApiResponse::response($data, [
                    'message' => [
                        'success' => [
                            'Date fetch successfully'
                        ]
                    ]
                ], 200, $request_time);
            }
        } catch (\Exception $e) {
            return ApiResponse::response([], [
                'error' => [
                    'Something Went Wrong !'
                ]
            ], 501, $request_time);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request_time = date('y-m-d h:i:s');
        $request->validate([
            'cid' => 'nullable|numeric',
            'title' => 'required|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'integer',
            'json' => 'required',
            'type' => 'required|numeric'
        ]);

        $data = new Document();
        $data->cid = $request->cid;
        $data->title = $request->title;
        $data->tags = json_encode($request->tags);
        $data->json = json_encode($request->json);
        $data->type = $request->type;
        $data->added_by = auth()->id();

        try {
            if ($data->save()) {

                $favourite = new Favourite();
                $favourite->model = 'document';
                $favourite->model_id = $data->id;
                $favourite->user_id = auth()->id();
                $favourite->save();

                $data->tags()->attach(json_decode(json_encode($request->tags), true));
                return ApiResponse::response($data, [
                    'success' => [
                        'Data store success'
                    ]
                ], 200, $request_time);
            }
        } catch (\Exception $e) {
            return ApiResponse::response([], [
                'error' => [
                    $e->getMessage()
                ]
            ], 501, $request_time);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request_time = date('y-m-d h:i:s');

        $document = Document::find($id);
        if (is_null($document)) {
            return ApiResponse::response($document, [
                'error' => [
                    'Document not found'
                ]
            ], 444, $request_time);
        }

        $request->validate([
            'cid' => 'nullable|numeric',
            'title' => 'nullable|string|max:255',
            'tags' => 'array',
            'tags.*' => 'integer',
            'json' => 'nullable',
            'type' => 'nullable|numeric'
        ]);
        $document->cid = $request->cid ?? $document->cid;
        $document->title = $request->title ?? $document->title;
        $document->tags = $request->tags ?? $document->tags;
        $document->json = $request->json ?? $document->json;
        $document->type = $request->type ?? $document->type;
        $document->added_by = auth()->id();
        try {
            if ($document->save()) {
                $tags = json_decode(json_encode($request->input('tags', [])), true);
                $document->tags()->sync($tags);
                return ApiResponse::response($document, [
                    'success' => [
                        'Document updated successfully'
                    ]
                ], 200, $request_time);
            }
        } catch (\Exception $e) {
            return ApiResponse::response([], [
                'error' => [
                    $e->getMessage()
                ]
            ], 501, $request_time);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($document)
    {
        $request_time = date('Y-m-d H:i:s');

        $document = Document::find($document);
        if (is_null($document)) {
            return ApiResponse::response($document, [
                'error' => [
                    'Document not found'
                ]
            ], 444, $request_time);
        }
        try {
            if ($document->delete()) {
                return ApiResponse::response($document, [
                    'message' => [
                        'success' => [
                            'Document Removed'
                        ]
                    ]
                ], 200, $request_time);
            }
        } catch (\Exception $e) {
            return ApiResponse::response([], [
                'message' => [
                    'error' => [
                        $e->getMessage()
                    ]
                ]
            ], 501, $request_time);
        }
    }
}
