<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table = 'plans';

    protected $fillable = [
        'name',
        'currency',
        'price',
        'duration',
        'features',
        'created_at',
        'updated_at'
    ];

    // protected $casts = [
    //     'features' => 'object'
    // ];
}
