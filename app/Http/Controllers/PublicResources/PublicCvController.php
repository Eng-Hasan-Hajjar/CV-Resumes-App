<?php

namespace App\Http\Controllers\PublicResources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ApiInvalidRequestData;
use App\Exceptions\ApiResourceNotFound;
use App\Cv;
use App\Http\Controllers\Controller;

class PublicCvController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        throw(new ApiResourceNotFound());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        throw(new ApiResourceNotFound());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        throw(new ApiResourceNotFound());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(String $id)
    {
        $data = CV::where('id', $id)->orWhere('uuid', $id)->with([
            'customFieldCategories', 
            'customFieldCategories.customFieldAttributeLines', 
            'customFieldCategories.customFieldRecords',
            'customFieldCategories.customFieldRecords.customFieldRecordAttributeLineValues'])
            ->firstOr(function() {
                throw(new ApiResourceNotFound("CV with specified ID cannot be found"));
            });
        if ($data['is_protected']) {
            if ($data['uuid'] == $id) {
                return response()->json([
                    'cv'=> $data,
                ]);
            }
            return response()->json([
                'detail'=>'data is protected'
            ], 401);
        }
        return response()->json([
            'cv'=>$data
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cv $cv)
    {
        throw(new ApiResourceNotFound());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cv $cv)
    {
        throw(new ApiResourceNotFound());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cv $cv)
    {
        throw(new ApiResourceNotFound());
    }
}
