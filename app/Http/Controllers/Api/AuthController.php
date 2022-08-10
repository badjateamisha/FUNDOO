<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @OA\POST(
     *   path="/api/registration",
     *   summary="User Registration",
     *   description="Registering through Name and Email",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"name","email", "password"},
     *               @OA\Property(property="name", type="string"),
     *               @OA\Property(property="email", type="string"),
     *               @OA\Property(property="password", type="string"),
     *            ),
     *        ),
     *    ),
     *   @OA\Response(response=201, description="User successfully registered"),
     *   @OA\Response(response=401, description="The email has already been taken"),
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    //Api for new user registration
    public function newregister(Request $request){
        $data = $request-> validate([
            'name' => 'string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string',
        ]);

        $userData = User::where('email', $request->email)->first();
        if($userData){
            Log::channel('custom')->error("The email has already been taken.");
         }
        else
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $token = $user->createToken('MyLaravelApp')->plainTextToken;

        $response = [
            'user'=>$user,
            'token'=>$token,
        ];
        Log::channel('custom')->info("User successfully registered");
        return response()->json(['Message' => "User successfully registered"]);
    }
 }

 /**
     * @OA\Post(
     *   path="/api/login",
     *   summary="login",
     *   description="login",
     *   @OA\RequestBody(
     *         @OA\JsonContent(),
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email","password"},
     *               @OA\Property(property="email", type="string"),
     *               @OA\Property(property="password", type="string"),
     *   
     *            ),
     *        ),
     *    ),
     *   @OA\Response(response=201, description="success"),
     *   @OA\Response(response=401, description="Invalid credentials"),
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    //API for Login
    public function login(Request $request)
    {
        $data = $request-> validate([
            
            'email' => 'required|email|max:100|',
            'password' => 'required|string',
        ]);

        $user = User::where('email',$data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password))
        {
            Log::channel('custom')->error("Invalid Credentials to Login");
            return response(['message' => 'Invalid Credentials'], 401);
        }
        else
        {
            $token = $user->createToken('MyLaravelApp')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
            ];
            Log::channel('custom')->info("Login succesfull");
            return response($response, 200);
        }
}

//API for logout
public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(['message'=>'Logged Out Successfully']);

    }

}