<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        if ($data->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data has beed added into database',
                'data' => $data
            ]);
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
        dd($request->all(), $document);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(document $document)
    {
        //
    }
}
