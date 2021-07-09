<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Profile extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table = 'password_profiles';

    protected $fillable = [
        'password',
        'app_id',
        'user'
    ];

    protected $appends = ['decoded_password'];

    public function GetDecodedPasswordAttribute() {
        return Crypt::decryptString($this->password);
    }

    public function app() {
        return $this->belongsTo(App::class, 'app_id');
    }
}
