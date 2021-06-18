<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request) {
        $validation = Validator($request->all(), [
            'subject' => ['required', 'string'],
            'message' => ['required', 'string']
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }

        return Contact::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'user_id' => auth()->user()->id
        ]);
    }
}
