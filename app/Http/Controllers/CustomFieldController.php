<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\ApiInvalidRequestData;
use App\Exceptions\ApiResourceNotFound;
use App\CustomFieldCategory;
use App\CustomFieldAttributeLine;
use App\CustomFieldRecord;
use App\CustomFieldRecordAttributeLineValue;


class CustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customFieldCategories = CustomFieldCategory::withoutTrashed()->with([
            'customFieldAttributeLines', 
            'customFieldRecords',
            'customFieldRecords.customFieldRecordAttributeLineValues'
        ])->get();
        return response()->json([
            'customFieldCategories'=> $customFieldCategories,
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

        $customFieldCategory = CustomFieldCategory::create($data);

        $customFieldAttributeLinesData = json_decode($request['customFieldAttributeLines']);
        $customFieldRecordsData = json_decode($request['customFieldRecords']);

        $customFieldAttributeLines = [];
        $customFieldRecords = [];
        $customFieldValues = [];

        // To do: Looping attribute lines
        foreach($customFieldAttributeLinesData as $attrLine) {
            $validatedAttrLine = $this->validateAttrLineRequest([
                'nama' => $attrLine->nama,
                'order' => $attrLine->order,
                'is_active' => $attrLine->is_active,
                'custom_field_category_id' => $customFieldCategory['id']
            ]);
            $newAttrLine = CustomFieldAttributeLine::create($validatedAttrLine);
            array_push($customFieldAttributeLines, $newAttrLine);
        }

        // To do: Looping records
        foreach($customFieldRecordsData as $record) {

            // Step 1: Assign row
            $validatedRecord = $this->validateRecordRequest([
                "order" => $record->order,
                "custom_field_category_id" => $customFieldCategory['id']
            ]);
            $newRecord = CustomFieldRecord::create($validatedRecord);
            array_push($customFieldRecords, $validatedRecord);

            $valuesData = $record->custom_field_record_attribute_line_values;

            // Step 2: Assign values (use second foreach) [TO DO]
            foreach($valuesData as $value) {
                $matchAttrLine = [
                    'custom_field_category_id' => $customFieldCategory['id'], 
                    'nama' => $value->custom_field_attribute_line_id
                ];

                $customFieldAttrLineTarget = CustomFieldAttributeLine::where(
                    $matchAttrLine)->get()->first();

                $validatedValue = $this->validateValueRequest([
                    "value" => $value->value, 
                    "custom_field_record_id" => $newRecord['id'], 
                    "custom_field_attribute_line_id" => $customFieldAttrLineTarget['id']
                ]);

                $newValue = CustomFieldRecordAttributeLineValue::create($validatedValue);

                array_push($customFieldValues, $newValue);
            }
        }

        return response()->json([
            'customFieldCategory'=>CustomFieldCategory::where('id', $customFieldCategory['id'])->with([
                'customFieldAttributeLines',
                'customFieldRecords',
                'customFieldRecords.customFieldRecordAttributeLineValues'
            ])->get()->first(),
            'status'=>"New custom field has been created"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return response()->json([
            'customFieldCategory'=> CustomFieldCategory::where('id', $id)->with([
                'customFieldAttributeLines',
                'customFieldRecords',
                'customFieldRecords.customFieldRecordAttributeLineValues'
            ])->firstOr(function() {
                throw(new ApiResourceNotFound('Custom Field with specified ID cannot be found'));
            }),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomFieldCategory $customFieldCategory)
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
    public function update(Request $request, int $id)
    {
        $customFieldCategory = CustomFieldCategory::where('id', $id)->firstOr(function() {
            throw new ApiResourceNotFound("Custom Field with specified ID cannot be found");
        });

        $data = $this->validateRequest($request);

        $customFieldCategory->update($data);

        $currentAttributeLines = CustomFieldAttributeLine::where('custom_field_category_id', $id)->get();
        $currentAttributeLineIds = $currentAttributeLines->map(function($attrLine) {return $attrLine['id'];})->toArray();

        $currentRecords = CustomFieldRecord::where('custom_field_category_id', $id)->get();
        $currentRecordIds = $currentRecords->map(function($record) {return $record['id'];})->toArray();

        $customFieldAttributeLinesData = json_decode($request['customFieldAttributeLines']);
        $customFieldRecordsData = json_decode($request['customFieldRecords']);

        $newAttributeLineIds = [];
        $newRecordIds = [];

        // To do: Looping attribute lines
        foreach($customFieldAttributeLinesData as $attrLine) {
            $validatedAttrLine = $this->validateAttrLineRequest([
                'nama' => $attrLine->nama,
                'order' => $attrLine->order,
                'is_active' => $attrLine->is_active,
                'custom_field_category_id' => $customFieldCategory['id']
            ]);
            
            $customFieldAttributeLine;

            // If already has ID, then do update
            if (isset($attrLine->id)) {
                $customFieldAttributeLine = CustomFieldAttributeLine::where('id', $attrLine->id)->first();
                $customFieldAttributeLine->update($validatedAttrLine);
            } else {
                $customFieldAttributeLine = CustomFieldAttributeLine::create($validatedAttrLine);
            }

            array_push($newAttributeLineIds, $customFieldAttributeLine['id']);
        }

        // To do: Looping records
        foreach($customFieldRecordsData as $record) {

            // Step 1: Assign row
            $validatedRecord = $this->validateRecordRequest([
                "order" => $record->order,
                "custom_field_category_id" => $customFieldCategory['id']
            ]);

            if (!isset($record->custom_field_record_attribute_line_values)) {
                throw(new ApiInvalidRequestData("A CustomFieldRecord must contain values"));
            }

            $customFieldRecord;
            // If already has ID, then do update
            if (isset($record->id)) {
                $customFieldRecord = CustomFieldRecord::where('id', $record->id)->first();
                $customFieldRecord->update($validatedRecord);
            } else {
                $customFieldRecord = CustomFieldRecord::create($validatedRecord);
            }
            array_push($newRecordIds, $customFieldRecord['id']);

            $valuesData = $record->custom_field_record_attribute_line_values;

            // Step 2: Assign values (use second foreach) [TO DO]
            foreach($valuesData as $value) {
                if (isset($value->id)) {
                    $validatedValue = $this->validateValueRequest([
                        "value" => $value->value, 
                        "custom_field_record_id" => $customFieldRecord['id'], 
                        "custom_field_attribute_line_id" => $value->custom_field_attribute_line_id
                    ]);
                    $customFieldRecordAttributeLineValue = CustomFieldRecord::where('id', $record->id)->first();
                    $customFieldRecordAttributeLineValue->update($validatedValue);
                } else {
                    $matchAttrLine = [
                        'custom_field_category_id' => $customFieldCategory['id'], 
                        'nama' => $value->custom_field_attribute_line_id
                    ];
    
                    $customFieldAttrLineTarget = CustomFieldAttributeLine::where(
                        $matchAttrLine)->get()->first();
    
                    $validatedValue = $this->validateValueRequest([
                        "value" => $value->value, 
                        "custom_field_record_id" => $customFieldRecord['id'], 
                        "custom_field_attribute_line_id" => $customFieldAttrLineTarget['id']
                    ]);
    
                    CustomFieldRecordAttributeLineValue::create($validatedValue);
                }
            }
        }

        // Deletion of missing attribute lines
        $missingAttrLineIds = array_diff($currentAttributeLineIds, $newAttributeLineIds);
        foreach($missingAttrLineIds as $attrLineId) {
            CustomFieldAttributeLine::where('id', $attrLineId)->delete();
            CustomFieldRecordAttributeLineValue::where('custom_field_attribute_line_id', $attrLineId)->delete();
        }

        // Deletion of missing records
        $missingRecordIds = array_diff($currentRecordIds, $newRecordIds);
        foreach($missingRecordIds as $recordId) {
            CustomFieldRecord::where('id', $recordId)->delete();
            CustomFieldRecordAttributeLineValue::where('custom_field_record_id', $recordId)->delete();
        }

        return response()->json([
            'customFieldCategory'=>CustomFieldCategory::where('id', $customFieldCategory['id'])->with([
                'customFieldAttributeLines',
                'customFieldRecords',
                'customFieldRecords.customFieldRecordAttributeLineValues'
            ])->get()->first(),
            'status'=>"Custom field has been updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $customFieldCategory = CustomFieldCategory::where('id', $id)->firstOr(function() {
            throw(new ApiResourceNotFound("Custom Field with specified ID cannot be found"));
        });

        $customFieldCategory->delete();

        CustomFieldAttributeLine::where('custom_field_category_id', $id)->delete();

        $customFieldRecords = CustomFieldRecord::where('custom_field_category_id', $id)->with([
            'customFieldRecordAttributeLineValues'
        ])->get();

        foreach($customFieldRecords as $record) {
            foreach($record['customFieldRecordAttributeLineValues'] as $value) {
                $value->delete();
            }
            $record->delete();
        }

        return response()->json([
            'customFieldCategory'=>$customFieldCategory,
            'status'=>"Custom field category has been deleted successfully",
        ]);
    }

    public function validateRequest($request, $thisModel = null){
        $validator = Validator::make($request->all(), [
            'nama'=>'required',
            'order'=>'required',
            'is_active'=>'required',
            'cv_id'=>'required'
        ]);

        if ($validator->fails()){
            throw(new ApiInvalidRequestData($validator->errors()));
        }

        return $validator->validated();
    }

    // Validate Attr Line
    public function validateAttrLineRequest($request, $thisModel = null){
        $validator = Validator::make($request, [
            'nama'=>'required',
            'order'=>'required',
            'is_active'=>'required',
            'custom_field_category_id'=>'required'
        ]);

        if ($validator->fails()){
            throw(new ApiInvalidRequestData($validator->errors()));
        }

        return $validator->validated();
    }

    // Validate Record
    public function validateRecordRequest($request, $thisModel = null){
        $validator = Validator::make($request, [
            'order'=>'required',
            'custom_field_category_id'=>'required'
        ]);

        if ($validator->fails()){
            throw(new ApiInvalidRequestData($validator->errors()));
        }

        return $validator->validated();
    }

    // Validate Value
    public function validateValueRequest($request, $thisModel = null){
        $validator = Validator::make($request, [
            'value'=>'nullable',
            'custom_field_record_id'=>'required',
            'custom_field_attribute_line_id'=>'required'
        ]);

        if ($validator->fails()){
            throw(new ApiInvalidRequestData($validator->errors()));
        }

        return $validator->validated();
    }

    //
}
