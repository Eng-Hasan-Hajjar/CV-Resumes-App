<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ApiInvalidRequestData;
use App\Cv;
use App\Profile;

class CvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cvs = Cv::withoutTrashed()->with(['customFieldCategories', 'customFieldCategories.customFieldAttributeLines'])->get();
        return response()->json([
            'cvs'=> $cvs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        if ($request->file('photo')) {
            $photo = $request->file('photo')->store('uploads/cv/photo','public');

            $data['photo'] = $photo;
        } else if($request->use_profile_photo == true){
            $profile = Profile::findOrFail($request->profile_id);
            $data["photo"] = $profile->photo;
        } else {
            unset($data['photo']);
        }

        $cv = Cv::create($data);

        return response()->json([
            'cv'=>$cv,
            'status'=>"New CV has been created successfully",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cv $cv)
    {
        $id = $cv->id;
        $data = CV::where('id', $id)->with([
            'customFieldCategories', 
            'customFieldCategories.customFieldAttributeLines', 
            'customFieldCategories.customFieldRecords',
            'customFieldCategories.customFieldRecords.customFieldRecordAttributeLineValues'])->get();
        return response()->json([
            'cv'=> $data->first(),
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
        //
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
        if($request->status == "update_cv"){
            $data = $this->validateRequest($request);

            $cv->update($data);

            return response()->json([
                'cv'=>$cv,
                'status'=>"Profile has been updated successfully",
            ]);
        }
        else if ($request->status == "update_photo"){
                $data = $this->validatePhotoRequest($request);
                $photo = $request->file('photo')->store('uploads/profile/photo','public');
                $data['photo'] = $photo;

                if ($cv->photo) {
                    unlink(public_path('storage/'.$cv->photo));
                }
                $cv->update($data);

                return response()->json([
                    'cv'=>$cv,
                    'status'=>"Photo Profile has been updated successfully",
                ]);
        }
        $data = $this->validateRequest($request);

        // Todo if fotonya didelete
        if ($request->file('photo')) {
            $photo = $request->file('photo')->store('uploads/cv/photo','public');

            $data['photo'] = $photo;
        } else {
            unset($data['photo']);
        }

        $cv->update($data);

        return response()->json([
            'cv'=>$cv,
            'status'=>"CV has been updated successfully",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cv $cv)
    {
        $cv->delete();

        return response()->json([
            'cv'=>$cv,
            'status'=>"CV has been deleted successfully",
        ]);
    }

    public function validateRequest(Request $request, $thisModel = null){
        
        $validator = Validator::make($request->all(), [
            'first_name'=>'required',
            'last_name'=>'required',
            'profession'=>'required',
            'photo'=>'nullable|image|mimes:jpeg,jpg,bmp,png|max:2000',
            'address'=>'nullable',
            'email'=>'required',
            'birth_date'=>'nullable',
            'phone'=>'nullable',
            'gender'=>'nullable',
            'password'=>'nullable',
            'is_active'=>'required',
            'is_protected'=>'required',
            'profile_id'=>'required',
            'use_profile_photo' => 'integer|nullable'
        ]); 
        
        if ($validator->fails()){
            throw(new ApiInvalidRequestData($validator->errors()));
        }

        return $validator->validated();
    }

    public function validatePhotoRequest($request, $thisModel = null){
        $validator = Validator::make($request->all(), [
            'photo'=>'nullable|image|mimes:jpeg,jpg,bmp,png|max:2000',
        ]);

        if ($validator->fails()){
            throw(new ApiInvalidRequestData($validator->errors()));
        }

        return $validator->validated();
    }
}
