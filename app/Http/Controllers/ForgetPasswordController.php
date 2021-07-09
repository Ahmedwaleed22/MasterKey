<?php

namespace App\Http\Controllers;

use App\Mail\password_reset_mail;
use App\Mail\success_password_reset_mail;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{
    public function forgetpassword(Request $request) {
        $request->validate([
            'email' => 'email|required',
        ]);

        $user = DB::table('users')->where('email', '=', $request->email)->first();

        //Check if the user exists
        if ($user == '') {
            return response()->json(['error' => 'User does not exist'], 404);
        }

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);

        //Get the token just created above
        $tokenData = DB::table('password_resets')->where('email', $request->email)->first();

        $this->sendResetEmail($request->email, $tokenData->token);

        return response()->json([
            "message" => "Email sent successfully"
        ]);
    }

    public function checktoken(Request $request) {
        $tokenData = DB::table('password_resets')->where('token', $request->resettoken)->first();

        if ($tokenData == null) {
            return response()->json([
                "valid" => false
            ], 404);
        }

        return response()->json([
            "valid" => true
        ], 200);
    }

    public function resetpassword(Request $request) {
        $request->validate([
            'password' => 'required|string',
            'resettoken' => 'required|string'
        ]);

        $tokenData = DB::table('password_resets')->where('token', $request->resettoken)->first();

        if ($tokenData == null) return response()->json(["error" => "Invalid Token"], 404);

        $user = User::whereEmail($tokenData->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $user->email)
        ->delete();

        $email = $user->email;

        try {
            Mail::to($email)->send(new success_password_reset_mail());
        } catch (\Exception $e) {
            return response()->json(["error" => $e], 500);
        }

        return response()->json([
            "message" => "Password Reset Successfully"
        ], 200);
    }

    private function sendResetEmail($email, $token) {
        Mail::to($email)->send(new password_reset_mail($token));

        if (Mail::failures()) {
            return new Error(Mail::failures());
        }

    }
}
