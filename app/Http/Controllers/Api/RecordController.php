<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Record;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    public function index()
    {
        $records = Record::all();

        if ($records->count() > 0) {
            return response()->json([
                'status' => 200,
                'records' => $records
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Records Found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $record = Record::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if ($record) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Created A Record Successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong'
                ], 500);
            }
        }
    }

    public function show($id)
    {
        $record = Record::find($id);

        if ($record) {
            return response()->json([
                'status' => 200,
                'record' => $record
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Record Found!'
            ], 404);
        }
    }

    public function edit($id)
    {
        $record = Record::find($id);

        if ($record) {
            return response()->json([
                'status' => 200,
                'records' => $record
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Record Found!'
            ], 404);
        }
    }

    public function update(Request $request, int $id)

    {

        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10', 
        ]);

        if ($validator->fails()){

            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        }else{

            $record = Record::find($id);
           
            if ($record) {
                // Update the record fields
                $record->update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);
    
            
                return response()->json([
                    'status' => 200,
                    'message' => 'Record Updated Successfully'

                ], 200);

            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Record Not Found!'

                ], 404);

            }
        }
    }

    public function destroy($id)
    {
        $record = Record::find($id);

        if ($record) {
            $record->delete();

            return response()->json([
                'status' => 202,
                'message' => 'Record Deleted!'
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Record Not Found!'
            ], 404);
        }
    }
}

