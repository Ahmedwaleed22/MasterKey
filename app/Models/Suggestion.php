<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $table = 'suggestions';

    protected $fillable = [
        'suggestion',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $appends = ['created_date'];

    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
