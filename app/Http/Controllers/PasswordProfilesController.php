<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Category;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PasswordProfilesController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function all() {
        $user = auth()->user();
        return Profile::with('app', 'app.category')->where('user', $user->id)->paginate(9);
    }

    public function all_without_pagination() {
        $user = auth()->user();
        return Profile::with('app', 'app.category')->where('user', $user->id)->get();
    }

    public function single($id) {
        $user = auth()->user();
        $profile = Profile::findOrFail($id);

        if ($user->id == $profile->user) {
            $app = App::all()->find($profile->app);
            $category_id = $app->category_id;
            $sameCategory = Profile::with('app', 'app.category')
                            ->where('user', $user->id)
                            ->where('id', '!=', $id)
                            ->whereHas('app.category', function ($q) use ($category_id) {
                                $q->where('categories.id', $category_id);
                            })
                            ->get();

            $sameCategory->makeHidden(['password', 'user']);
    
            return response()->json([
                "password" => Crypt::decryptString($profile->password),
                "app_name" => $app->name,
                "description" => $app->description,
                "form_same_category" => $sameCategory
            ]);

        } else {
            return response()->json([
                "error" => "You don't have access to this profile"
            ]);
        }
    }

    public function store(Request $request) {
        $request->validate([
            'password' => 'required|string|min:8',
            'app' => 'required|numeric'
        ]);

        return Profile::create([
            'password' => Crypt::encryptString($request->password),
            'user' => auth()->user()->id,
            'app_id' => $request->app
        ]);
    }

    public function delete($id) {
        $profile = Profile::find($id);

        if ($profile->user == auth()->user()->id) {
            $profile->delete();

            return response()->json([
                "success" => true,
                "message" => "Password profile successfully deleted"
            ]);
        }

        return response()->json([
            "success" => false,
            "message" => "Password profile cannot deleted"
        ]);
    }
}
