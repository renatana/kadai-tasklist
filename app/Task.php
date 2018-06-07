<?php

namespace App;

use Illuminate\database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['content','status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}