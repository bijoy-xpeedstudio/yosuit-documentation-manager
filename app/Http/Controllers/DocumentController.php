<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;

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
            'cid' => 'required|numeric',
            'title' => 'required|string|max:255',
            'tags' => 'nullable|string',
            'json' => 'required|string',
            'type' => 'required|numeric'
        ]);

        $data = new Document();
        $data->cid = $request->cid;
        $data->title = $request->title;
        $data->tags = $request->tags;
        $data->json = $request->json;
        $data->type = $request->type;
        $data->added_by = auth()->id();

        try {
            if ($data->save()) {
                $data->tags()->attach(json_decode($request->tags, true));
                return ApiResponse::response($data, [
                    'success' => [
                        'Data store success'
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
            'cid' => 'required|numeric',
            'title' => 'required|string|max:255',
            'tags' => 'required|string',
            'json' => 'required|string',
            'type' => 'required|numeric'
        ]);

        $document->cid = $request->cid;
        $document->title = $request->title;
        $document->tags = $request->tags;
        $document->json = $request->json;
        $document->type = $request->type;
        $document->added_by = auth()->id();
        try {
            if ($document->save()) {
                $tags = json_decode($request->input('tags', []), true);
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
