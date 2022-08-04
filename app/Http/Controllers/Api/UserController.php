<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
 

class UserController extends Controller
{
    public $successToken = 200;
    /**
     * @OA\Post(
     *   path="/api/newregister",
     *   summary="register",
     *   description="register",
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
    public function register(Request $request)
    {
        $userData=User::where('email',$request->email)->first();
        if($userData){
            Log::channel('custom')->debug("the email has already registered");
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);
        $token=$user->createToken('Token')->accessToken;
        return response()->json(['token'=>$token,'user'=>$user]);
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
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="string"),
     *               @OA\Property(property="password", type="string"),
     *            ),
     *        ),
     *    ),
     *   @OA\Response(response=201, description="User successfully logged in "),
     *   @OA\Response(response=401, description="Invalid Login"),
     * )
     * 
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $result = Auth::attempt(['email'=> $request->email, 'password' => $request ->password]);
        if($result){
            $user = new User();
            $success['token'] = $user->createToken('MyLaravelApp')->accessToken;
            return response()->json(['success'=>$success], $this->successToken);
        }
        else{
            Log::channel('custom')->error("You entered wrong password");
            return response()->json(['error'=>'Unauthorised'], 401);
        }        
    }
    public function userInfo(Request $request){
        $user = User::all();
        return response()->json(['success' => $user], $this->successToken);
         //return "welcome";
     }
    }