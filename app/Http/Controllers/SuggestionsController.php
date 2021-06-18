<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionsController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => 'latest']);
    }

    public function latest() {
        return Suggestion::with('user')->orderBy('id', 'DESC')->limit(5)->get();
    }

    public function store(Request $request) {
        $request->validate([
            'suggestion' => 'string|required'
        ]);

        return Suggestion::create([
            'suggestion' => $request->suggestion,
            'user_id' => auth()->user()->id
        ]);
    }
}
