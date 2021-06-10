<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;

    protected $table = 'apps';

    public function profiles() {
        return $this->hasMany(Profile::class, 'app');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category');
    }
}
