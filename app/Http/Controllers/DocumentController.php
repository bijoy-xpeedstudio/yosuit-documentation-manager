<?php

namespace App\Http\Controllers;

use App\Models\document;
use Illuminate\Http\Request;
// use Validator;

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
            'tags' => 'required|array',
            'json' => 'required|string',
            'type' => 'required|numeric'
        ]);

        dd('okook');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(document $document)
    {
        //
    }
}
