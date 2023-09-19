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
            $data = Document::with('cid.subFolder', 'addedBy')->paginate(16);
            if ($data) {
                return ApiResponse::success($data, 'Success', 200, $request_time);
            }
        } catch (\Exception $e) {
            return ApiResponse::serverException([], 'Something Went Wrong !', 501, $request_time);
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
            'tags' => 'required|string',
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
                return ApiResponse::success($data, 'Success', 200, $request_time);
            }
        } catch (\Exception $e) {
            return ApiResponse::serverException([], 'Something Went Wrong !', 501, $request_time);
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
    public function update(Request $request, document $document)
    {
        $request_time = date('y-m-d h:i:s');
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
                return ApiResponse::success($document, 'data updated successfull', 200, $request_time);
            }
        } catch (\Exception $e) {
            return ApiResponse::serverException([], 'Something Went Wrong !', 501, $request_time);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(document $document)
    {
        $request_time = date('Y-m-d H:i:s');
        try {
            if ($document->delete()) {
                return ApiResponse::success($document, 'data deleted successfull', 200, $request_time);
            }
        } catch (\Exception $e) {
            return ApiResponse::serverException([], 'Something Went Wrong !', 501, $request_time);
        }
    }
}
