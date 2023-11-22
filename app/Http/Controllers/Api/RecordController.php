<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Record;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{   
    /**
 * @OA\Get(
 *     path="/api/record",
 *     tags={"Get Records"},
 *     summary="Get all records",
 *     description="Retrieves all records from the database.",
 *     operationId="getAllRecords",
 *     @OA\Response(
 *         response="200",
 *         description="Records retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="records", type="array", @OA\Items(type="object"))
 *         )
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="No records found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="No Records Found")
 *         )
 *     )
 * )
 */

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
/**
 * @OA\Post(
 *     path="/api/record",
 *     tags={"Create A Record"},
 *     summary="Create a Record",
 *     description="Creates a new record with the provided data.",
 *     operationId="createRecord",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     description="Name of the user",
 *                     example="John Doe"
 *                 ),
 *                 @OA\Property(
 *                     property="course",
 *                     type="string",
 *                     description="Name of the course",
 *                     example="Computer Science"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     description="User's email",
 *                     example="john@example.com"
 *                 ),
 *                 @OA\Property(
 *                     property="phone",
 *                     type="string",
 *                     description="User's phone number",
 *                     example="1234567890"
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Record created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Created A Record Successfully"),
 *         )
 *     ),
 *     @OA\Response(
 *         response="422",
 *         description="Validation errors",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=422),
 *             @OA\Property(property="errors", type="object", example={"name": {"The name field is required."}}),
 *         )
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="message", type="string", example="Something Went Wrong"),
 *         )
 *     )
 * )
 */

    
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

    /**
 * @OA\Get(
 *     path="/api/record/{id}",
 *     tags={"Get Records by {id}"},
 *     summary="Get a Record by ID",
 *     description="Retrieves a record by its ID.",
 *     operationId="getRecordById",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the record",
 *         @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Record retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="record", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="course", type="string", example="Computer Science"),
 *                 @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *                 @OA\Property(property="phone", type="string", example="1234567890")
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="Record not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="No Such Record Found!")
 *         )
 *     )
 * )
 */

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

    /**
 * @OA\Put(
 *     path="/api/record/{id}/edit",
 *     tags={"Update Record By {id}"},
 *     summary="Update a Record by ID",
 *     description="Updates a record with the provided data by ID.",
 *     operationId="updateRecord",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the record to be updated",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     description="Name of the user",
 *                     example="John Doe"
 *                 ),
 *                 @OA\Property(
 *                     property="course",
 *                     type="string",
 *                     description="Name of the course",
 *                     example="Computer Science"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     description="User's email",
 *                     example="john@example.com"
 *                 ),
 *                 @OA\Property(
 *                     property="phone",
 *                     type="string",
 *                     description="User's phone number",
 *                     example="1234567890"
 *                 ),
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Record updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=200),
 *             @OA\Property(property="message", type="string", example="Record Updated Successfully"),
 *         )
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="Record not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="Record Not Found"),
 *         )
 *     ),
 *     @OA\Response(
 *         response="422",
 *         description="Validation errors",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=422),
 *             @OA\Property(property="errors", type="object", example={"name": {"The name field is required."}}),
 *         )
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="message", type="string", example="Something Went Wrong"),
 *         )
 *     )
 * )
 */

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

    /**
 * @OA\Delete(
 *     path="/api/record/{id}",
 *     tags={"Delete A Record"},
 *     summary="Delete a Record by ID",
 *     description="Deletes a record with the specified ID.",
 *     operationId="deleteRecord",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the record to be deleted",
 *         @OA\Schema(type="integer", format="int64")
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Record deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=202),
 *             @OA\Property(property="message", type="string", example="Record Deleted!"),
 *         )
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="Record not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=404),
 *             @OA\Property(property="message", type="string", example="Record Not Found!"),
 *         )
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="integer", example=500),
 *             @OA\Property(property="message", type="string", example="Something Went Wrong"),
 *         )
 *     )
 * )
 */
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

