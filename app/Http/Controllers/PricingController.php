<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function all() {
        return Plan::all();
    }
}
