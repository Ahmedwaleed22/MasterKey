<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contact';

    protected $fillable = [
        'subject',
        'message',
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
