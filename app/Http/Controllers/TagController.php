<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use App\Models\Tag;
use App\Http\Requests\TagRequest;
class TagController extends Controller
{



    public function index()
    {
        $request_time = date('y-m-d h:i:s');
        try {
            $data =  Tag::with( 'addedBy')->orderBy('id','desc')->get();
            return ApiResponse::response($data, [
                'success' => [
                    'Tags Fetched  successfully'
                ]
            ], 200, $request_time);
        } catch (\Exception $e) {
            return ApiResponse::response([], [
                'error' => [
                    $e->getMessage()
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
    public function store(TagRequest $request)
    {
        $request_time = date('y-m-d h:i:s');
        $request = $request->validated();
        try {
            $tag = new Tag();
            $tag->tag_name=$request['tag_name'];
            $tag->added_by=auth()->id();
            $tag->save();
            $data=Tag::with( 'addedBy')->find($tag->id);
            return ApiResponse::response($data, [
                'success' => [
                    'Tags Added  successfully'
                ]
            ], 200, $request_time);
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
    public function show(string $search_text)
    {
        $request_time = date('y-m-d h:i:s');
        try {
            $data = Tag::with('addedBy')
                        ->where('tag_name', 'LIKE', "%{$search_text}%")
                        ->orderBy('id', 'desc')
                        ->get();
            return ApiResponse::response($data, [
                'success' => [
                    'Tag fetch  successfully'
                ]
            ], 200, $request_time);
        } catch (\Exception $e) {
            return ApiResponse::response([], [
                'error' => [
                    $e->getMessage()
                ]
            ], 501, $request_time);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, string $id)
    {
        $request_time = date('y-m-d h:i:s');
        $request = $request->validated();
        try {
            $tag =Tag::find($id);
            $tag->tag_name=$request['tag_name'];
            $tag->added_by=auth()->id();
            $tag->save();
            $data=Tag::with( 'addedBy')->find($tag->id);
            return ApiResponse::response($data, [
                'success' => [
                    'Tags Updated  successfully'
                ]
            ], 200, $request_time);
        } catch (\Exception $e) {
            return ApiResponse::serverException([], 'Something Went Wrong !', 501, $request_time);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $request_time = date('y-m-d h:i:s');
        try {
            $tag =Tag::find($id);
            $tag->delete();
            return ApiResponse::success($tag, 'Success', 200, $request_time);
        } catch (\Exception $e) {
            return ApiResponse::response([], [
                'error' => [
                    $e->getMessage()
                ]
            ], 501, $request_time);
        }
    }
}
