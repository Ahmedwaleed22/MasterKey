<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware(['auth:api', 'is_staff']);
    }

    public function all_users() {
        return User::all();
    }
}
