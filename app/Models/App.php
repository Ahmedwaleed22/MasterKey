<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table = 'apps';

    protected $fillable = [
        'id',
        'logo',
        'name',
        'link',
        'short_description',
        'description',
        'category_id',
        'created_at',
        'updated_at'
    ];

    public function profiles() {
        return $this->hasMany(Profile::class, 'app');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
