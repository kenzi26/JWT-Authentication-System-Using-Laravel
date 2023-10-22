<?php

namespace App\Http\Controllers\Api;

use auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    public function _construct(){
        $this->middleware('auth:api', ['expect' => ['login', 'register']]);
    }
    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Register"},
     *     summary="Register a new user",
     *     description="Registers a new user with the provided information.",
     *     operationId="registerUser",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="User's name",
     *                     example="John Doe"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     description="User's email",
     *                     example="john@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="User's password",
     *                     example="password123"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User registered successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation errors",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Validation errors"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="field_name", type="array", @OA\Items(type="string", example="The field is required."))
     *             )
     *         )
     *     )
     * )
     */

    public function register(Request $request){

        $validator = Validator::make($request->all(), [

            'name' => 'required|string|max:191',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]); 
        if ($validator->fails()){

            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }else{
            $user = User::create(array_merge(
                $validator-> validated(),
                ['password' => bcrypt($request -> password)]
            ));
            if($user){
            
                return response()->json([
                    'message' => 'User Successfully Registered',
                    'user' => $user

                ], 201);

            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong'

                ], 500);

            }
    }   }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
        if ($validator->fails()){

            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ], 400);
        }
        if (! $token = auth()->attempt($validator -> validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->CreateNewToken($token);

    }
    public function CreateNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth() ->user()
        ]);
    } 
    

    public function refresh()
{
    return $this->CreateNewToken(auth()->refresh());
}



    public function me (){
        return response()->json(auth()->user());
    }

    public function logout(){
        auth()->logout();
        return response()->json([
            'message' => 'User Logged Out'

        ], 201);

    }
}   

    

