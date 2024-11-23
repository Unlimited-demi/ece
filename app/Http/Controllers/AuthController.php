<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator as Validate;
use Illuminate\Validation\Rules\Password;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;
     /**
        * @OA\Post(
        * path="/api/register",
        * operationId="register",
        * tags={"Authentication"},
        * summary="User register",
        * description="User register to gain access to dashboard",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"name","email", "password", "password_confirmation"},
               *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="email", type="email"),
        *       @OA\Property(property="password", type="text", description="Must be at least 8 characters long and include at least one letter, digit, and symbol."),
        *               @OA\Property(property="password_confirmation", type="text"),
        *            ),
        *        ),
        *    ),
        
        *      @OA\Response(
 *     response=201,
 *     description="Registration complete! You can proceed to login.",
 *     @OA\JsonContent(),
 * ),
 * @OA\Response(
 *     response=400,
 *     description="Bad request",
 *     @OA\JsonContent(
 *         type="object",
 *         @OA\Property(property="errors", type="object", example={"field_name": {"validation_error_message"}})
 *     )
 * ),
         * )
        */
    public function register(Request $request) {
        $validator = Validate::make($request->all(), [
            'email' => 'required|string|unique:users,email',
            'name' => 'required|string',
            'password' => [ // password_confirmation field should be sent  
                'required', 'confirmed','string',
                Password::min(8)->letters()->numbers()->symbols(),
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
 
        $data = $request->all(); 
        $data['role'] = 'staff';
        $user = User::create($data);
        $token = $user->createToken('user')->plainTextToken;
       
        return $this->success([
            'user' => $user,
            'token' => $token
        ], 'Registration complete! You can proceed to login.', 201);
    }

         /**
        * @OA\Post(
        * path="/api/login",
        * operationId="login",
        * tags={"Authentication"},
        * summary="Login",
        * description="User login",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"email", "password"},
        *               @OA\Property(property="email", type="email"),
        *               @OA\Property(property="password", type="text"),
        *            ),
        *        ),
        *    ),
       
 *           @OA\Response(
 *     response=200,
 *     description="Successful response",
 *     @OA\JsonContent(
 *         type="object",
 *         @OA\Property(
 *             property="status",
 *             type="string",
 *             example="success",
 *         ),
 *         @OA\Property(
 *             property="message",
 *             type="null",
 *             example=null,
 *         ),
 *         @OA\Property(
 *             property="data",
 *             type="object",
 *             @OA\Property(
 *                 property="user",
 *                 type="object",
            * example={"user_property": "user_value"},
            * ),
 *             @OA\Property(property="token", type="string", example="your_access_token_value"),
 *         ),
 *     ),
 * ),
 
 * @OA\Response(
 *     response=400,
 *     description="Bad request",
 *     @OA\JsonContent(
 *         type="object",
 *         @OA\Property(property="errors", type="object", example={"field_name": {"validation_error_message"}})
 *     )
 * ),
 * 
 * @OA\Response(
 *     response=422,
 *     description="Authentication error",
 *     @OA\JsonContent(
 *         type="object",
 *         @OA\Property(
 *             property="error",
 *             type="string",
 *             example="Credentials Invalid"
 *         ),
 *     ),
 * ),
        * )
        */
    public function login(Request $request) {
        $validator = Validate::make($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || ! Hash::check($request->password, $user->password)) {
            return $this->error(null, 'Credentials Invalid', 422);
        }

        $token = $user->createToken('user')->plainTextToken;
        return $this->success([
            'user' => $user,
            'token' => $token
        ], 'Login successful!');
    }

          /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout user",
     *     description="Logout the currently authenticated user and revoke the access token.",
     *     operationId="logout",
     *     tags={"Authentication"},
     *     security={
     *         {"sanctum": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logged out!"),
     *         ),
     *     ),
     * )
     */
    public function logout() {
        $user = request()->user();
        $user->currentAccessToken()->delete();

        return $this->success(null, 'Logged out!');
    }
}
