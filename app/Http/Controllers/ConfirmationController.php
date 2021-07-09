<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;

class ConfirmationController extends Controller
{
    public function confirm_account($confirmation_token) {
        $user = User::where('confirmation_token', '=', $confirmation_token)->first();

        if ($user) {
            $user->email_verified_at = Carbon::now();
            $user->confirmation_token = null;
            $user->save();

            return redirect('/login');
        } else {
            return redirect('/login');
        }
    }
}
