<?php

namespace App\Http\Controllers;

use App\Mail\login_2fa;
use App\Mail\registration_mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Error;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'is_valid', 'verify_login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validated = Validator($request->all(), [
            'email' => 'string|required',
            'password' => 'string|required'
        ]);

        if ($validated->failed()) {
            return response()->json($validated->errors(), 500);
        }

        $user_check = User::where('email', '=', $request->email)->first();

        if ($user_check == null) {
            return response()->json(['message' => 'Account Not Found'], 401);
        }

        $verified_date = $user_check->email_verified_at;

        if ($verified_date == null) {
            return response()->json(['message' => 'Account Not Verified'], 401);
        }

        $user = User::where('email', '=', $request->email)->first();

        if (! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Wrong Credentials'], 401);
        }

        $code = mt_rand(100000, 999999);

        $user->login_2fa = $code;
        $user->login_2fa_expiration_date = Carbon::now()->addMinutes(15);
        $user->save();

        $this->send2facode($request->email, $code);
        return response()->json($user, 200);
    }

    public function verify_login(Request $request) {
        $request->validate([
            'email' => 'string|required',
            'login_token' => 'string|required'
        ]);

        $user = User::where('email', '=', $request->email)->first();

        if ($user && $user->login_2fa == $request->login_token && $user->login_2fa_expiration_date < Carbon::now()->addMinutes(15)) {
            $token = JWTAuth::fromUser($user);
            $user->login_2fa = null;
            $user->login_2fa_expiration_date = null;
            $user->save();

            return $this->respondWithToken($token, $user);
        }

        return response()->json(['message' => 'There is an error'], 500);
    }

    public function register(Request $request)
    {
        $validation = Validator($request->all(), [
            'username' => ['required', 'unique:users', 'max:255'],
            'email' => ['required', 'unique:users', 'max:255'],
            'password' => ['required', 'max:255'],
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        $token = str_random(60);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'confirmation_token' => $token
        ]);

        $this->sendConfirmationEmail($request->email, $token);

        return $user;
    }

    private function sendConfirmationEmail($email, $token) {
        Mail::to($email)->send(new registration_mail($token));

        if (Mail::failures()) {
            return new Error(Mail::failures());
        }

    }

    private function send2facode($email, $code) {
        Mail::to($email)->send(new login_2fa($code));

        if (Mail::failures()) {
            return new Error(Mail::failures());
        }

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function is_valid() {
        return response()->json([ 'valid' => auth('api')->check() ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }
}
