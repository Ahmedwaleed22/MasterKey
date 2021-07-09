<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

    public function apps() {
        return $this->hasMany(App::class, 'category');
    }
}
