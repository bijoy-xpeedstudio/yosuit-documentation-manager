<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Http\Responses\ApiResponse;
use App\Http\Requests\FolderRequest;
class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request_time = date('y-m-d h:i:s');
        try {
            $data=Folder::with('subFolder')->where(['parent_id'=> null,])->where('is_active', true)->orderBy('id')->get();
            return ApiResponse::success($data, 'Success', 200, $request_time);

        } 
        catch (\Exception $e) {
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
    public function store(FolderRequest $request)
    {
        $request_time = date('y-m-d h:i:s');
        $requestData = $request->validated();
        try {
            $data=array();// for demo
            return ApiResponse::success($data, 'Success', 200, $request_time);

        } 
        catch (\Exception $e) {
            return ApiResponse::serverException([], 'Something Went Wrong !', 501, $request_time);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
