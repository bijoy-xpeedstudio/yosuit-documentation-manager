<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;
use App\Models\Document;
use App\Models\Folder;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request_time = date('Y-m-d H:i:s');

        $data = Favourite::with('userId')->where('user_id', auth()->id())->get();

        foreach ($data as $key => $value) {
            if ($value->model == 'document') {
                $model_data = Document::where('id', $value->model_id)->first();

                $mdata = [
                    'id' => $model_data->id,
                    'name' => $model_data->title,
                    'type' => 'document'
                ];
            } else if ($value->model == 'folder') {
                $model_data = Folder::where('id', $value->model_id)->first();

                $mdata = [
                    'id' => $model_data->id,
                    'name' => $model_data->name,
                    'type' => 'folder'
                ];
            }

            $value->model = $mdata;
        }

        return ApiResponse::response($data, [
            'success' => [
                'Tag fetch  successfully'
            ]
        ], 200, $request_time);
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
        $request_time = date('Y-m-d H:i:s');
        $request->validate([
            'type' => 'in:favourite,location,document,folder',
            'favourite_id' => 'required|numeric'
        ]);

        $data = new Favourite();
        $data->model = $request->type;
        $data->model_id = $request->fevourite_id;
        $data->user_id = auth()->id();

        try {
            if ($data->save()) {
                return ApiResponse::response($data, [
                    'success' => [
                        'Tag fetch  successfully'
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
    public function show(Fevourite $fevourite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fevourite $fevourite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fevourite $fevourite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($favourite)
    {
        $request_time = date('Y-m-d H:i:s');

        $favourite = Favourite::find($favourite);

        if (is_null($favourite)) {
            return ApiResponse::response($favourite, [
                'error' => [
                    'Fevourite not found'
                ]
            ], 444, $request_time);
        }
        try {
            if ($favourite->delete()) {
                return ApiResponse::response($favourite, [
                    'message' => [
                        'success' => [
                            'Fevourite Removed'
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
