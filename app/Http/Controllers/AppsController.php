<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;

class AppsController extends Controller
{
    public function all() {
        return App::all();
    }
}
