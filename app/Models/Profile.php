<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'password_profiles';

    protected $fillable = [
        'password',
        'app',
        'user'
    ];

    public function app() {
        return $this->belongsTo(App::class, 'app');
    }
}
