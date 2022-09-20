<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ApiInvalidRequestData;
use App\Profile;
use App\ProfileAttributeLine;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::withoutTrashed()->with('cvs')->with('profileAttributeLine')->get();
        return response()->json([
            'profiles'=> $profiles,
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
            $photo = $request->file('photo')->store('uploads/profile/photo','public');

            $data['photo'] = $photo;
        } else {
            unset($data['photo']);
        }

        $profile = Profile::create($data);

        return response()->json([
            'profile'=>$profile,
            'status'=>"New profile has been created successfully",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        $id = $profile->id;
        $data = Profile::where('id', $id)->with(['cvs', 'profileAttributeLine'])->first(); 
        return response()->json([
            'profile'=> $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
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
    public function update(Request $request, Profile $profile) // Not a good practice, need to divide the function to as micro as possible
    {
        if ($request->status == 'update-profile') {
            $data = $this->validateRequest($request);

            $profile->update($data);

            return response()->json([
                'profile'=>$profile,
                'status'=>"Profile has been updated successfully",
            ]);
        } else {
            if ($request->status == 'update-photo') {
                $data = $this->validatePhotoRequest($request);
                $photo = $request->file('photo')->store('uploads/profile/photo','public');
                $data['photo'] = $photo;

                if ($profile->photo) {
                    unlink(public_path('storage/'.$profile->photo));
                }
                $profile->update($data);

                return response()->json([
                    'profile'=>$profile,
                    'status'=>"Photo Profile has been updated successfully",
                ]);
            } else {
                if($profile->photo) {
                    unlink(public_path('storage/'.$profile->photo));
                    $data['photo'] = null;
                    $profile->update($data);

                    return response()->json([
                        'profile'=>$profile,
                        'status'=>"Photo Profile has been removed successfully",
                    ]);
                } else {
                    return response()->json([
                        'profile'=>$profile,
                        'error' => true,
                        'status'=>"Fail to remove photo profile since there isn't one you dummy dum dum",
                    ]);
                }
            }
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();

        return response()->json([
            'profile'=>$profile,
            'status'=>"Profile has been deleted successfully",
        ]);
    }

    public function addProfileAttributeLine(Request $request, $id_profile)
    {
        $data = $this->validateAttributeLine($request->all());
        $data['profile_id'] = $id_profile;
        
        $profile_attribute_line = ProfileAttributeLine::create($data);
        
        return response()->json([
            'data' => $profile_attribute_line,
            'response' => 'Profile Attribute Line has been created successfully'
        ]);

    }

    public function updateProfileAttributeLine(Request $request, $id_profile)
    {
        $profile_attribute_lines = json_decode($request->profile_attribute_lines);
        $temp = [];
        foreach ($profile_attribute_lines as $profile_attribute_line){
            $data = $this->validateAttributeLine((array) $profile_attribute_line);

            $attribute_line = ProfileAttributeLine::where('id', $profile_attribute_line->id)->first();
            $attribute_line->update($data);
            array_push($temp, $data);
        }
        return response()->json([
            'status' => 'Profile Attribute Lines has been updated successfully',
            'data'=>$temp
        ]);
    }

    public function deleteProfileAttributeLine(Request $request, $id_profile)
    {
        $profile_attribute_lines_id = json_decode($request->profile_attribute_lines_id);
        $temp = [];
        foreach ($profile_attribute_lines_id as $id){
            ProfileAttributeLine::where('id', $id)->delete();
            array_push($temp, $id);
        }
        return response()->json([
            'status' => 'Profile Attribute Lines ID '.implode(",", $temp).' has been deleted successfully',
            'data'=>$temp
        ]);
    }

    public function validateAttributeLine($arr, $thisModel = null){
        $validator = Validator::make($arr, [
            'name'=>'required',
            'value'=>'required',
            'order'=>'required'
        ]);

        if ($validator->fails()){
            throw(new ApiInvalidRequestData($validator->errors()));
        }

        return $validator->validated();
    }

    public function validateRequest($request, $thisModel = null){
        $validator = Validator::make($request->all(), [
            'first_name'=>'required',
            'last_name'=>'required',
            'profession'=>'required',
            'address'=>'nullable',
            'email'=>'nullable',
            'birth_date'=>'nullable',
            'phone'=>'nullable',
            'gender'=>'nullable',
            'user_id'=>'required'
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
