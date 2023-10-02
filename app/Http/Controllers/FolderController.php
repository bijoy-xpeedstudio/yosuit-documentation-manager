<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Http\Responses\ApiResponse;
use App\Http\Requests\FolderRequest;
use App\Models\Favourite;
use Illuminate\Support\Facades\DB;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request_time = date('y-m-d h:i:s');
        try {
            $data = Folder::with('subFolder', 'addedBy', 'tags', 'documents')->where(['parent_id' => null,])->where('is_active', true)->orderBy('id')->get();
            return ApiResponse::response($data, [
                'success' => [
                    'Folder Fetch Successfully'
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
    public function store(FolderRequest $request)
    {
        $request_time = date('y-m-d h:i:s');
        $requestData = $request->validated();
        try {
            $folder = new Folder();
            $folder->parent_id = $request['parent_id'] ?? null;
            $folder->name = $requestData['name'];
            $folder->is_active = $request['is_active'] ?? 1;
            $folder->added_by = auth()->id();
            $folder->save();

            $fevourite = new Favourite();
            $fevourite->model = 'folder';
            $fevourite->model_id = $folder->id;
            $fevourite->user_id = auth()->id();
            $fevourite->save();

            $folder->tags()->attach(json_decode($request->tags, true));
            $folder = Folder::with('subFolder', 'addedBy', 'tags')->where('is_active', true)
                ->where('id', $folder->id)->get();
            return ApiResponse::response($folder, [
                'success' => [
                    'Folder save successfully'
                ]
            ], 200, $request_time);
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


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request_time = date('y-m-d h:i:s');
        try {
            $data = Folder::with('subFolder', 'addedBy', 'tags', 'documents')->where('id', $id)->first();

            if (is_null($data)) {
                return ApiResponse::response($data, [
                    'error' => [
                        'Document not found'
                    ]
                ], 444, $request_time);
            }
            return ApiResponse::response($data, [
                'success' => [
                    'Data fetch successfully'
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
    public function edit(FolderRequest $request, string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request_time = date('y-m-d h:i:s');
        $request->validate([
            'name' => 'nullable|string|max:255',
        ]);
        DB::beginTransaction();
        try {
            $folder = Folder::find($id);
            if (is_null($folder)) {
                return ApiResponse::response($folder, [
                    'error' => [
                        'Document not found'
                    ]
                ], 444, $request_time);
            }
            $folder->parent_id = $request['parent_id'] ?? $folder->parent_id;
            $folder->name = $request['name'] ?? $folder->name;
            $folder->is_active = $request['is_active'] ?? 1;
            $folder->added_by = auth()->id();
            $folder->save();
            //$tags = json_decode($request->input('tags', []), true);
            $tags = $request->input('tags', []);
            if ($tags) {
                $folder->tags()->sync($tags);
            }
            DB::commit();
            $folder = Folder::with('subFolder', 'addedBy', 'tags')->findorFail($id);
            return ApiResponse::response($folder, [
                'success' => [
                    'Folder Update successfully'
                ]
            ], 200, $request_time);
        } catch (\Exception $e) {
            DB::rollBack();
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
    public function destroy(string $id)
    {
        $request_time = date('Y-m-d H:i:s');
        $folder = Folder::find($id);
        if (is_null($folder)) {
            return ApiResponse::response($folder, [
                'error' => [
                    'Document not found'
                ]
            ], 444, $request_time);
        }
        try {
            if ($folder->parent_id == null) {
                Folder::where('parent_id', $folder->id)->delete();
            }
            $folder->delete();
            $folder = Folder::with('subFolder')->where(['parent_id' => null,])->where('is_active', true)->orderBy('id')->get();
            return ApiResponse::response($folder, [
                'success' => [
                    'Folder removed successfully'
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
    // Demo method for Polymorphic Pivot Integration
    public function polyPivot(Request $request)
    {
        DB::beginTransaction();
        try {
            $folder = new Folder();
            $folder->parent_id = $request['parent_id'] ?? null;
            $folder->name = $request['name'];
            $folder->is_active = $request['is_active'] ?? 1;
            $folder->added_by = auth()->id();
            $folder->save();
            $folder->tags()->attach(json_decode($request->tags, true));
            DB::commit();
            return Folder::with('tags')->find($folder->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
