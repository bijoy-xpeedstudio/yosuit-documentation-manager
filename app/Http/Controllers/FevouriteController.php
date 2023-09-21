<?php

namespace App\Http\Controllers;

use App\Models\Fevourite;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;

class FevouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request_time = date('Y-m-d H:i:s');

        $data = Fevourite::where('user_id', auth()->id())->get();
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
            'type' => 'in:fevourite,location,document,folder',
            'fevourite_id' => 'required|numeric'
        ]);

        $data = new Fevourite();
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
    public function destroy(Fevourite $fevourite)
    {
        //
    }
}
