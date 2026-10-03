<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 

class TeamRequest extends Model
{
    protected $fillable = ['user_id', 'requested_role_id', 'message', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requestedRole()
    {
        return $this->belongsTo(Role::class, 'requested_role_id');
    }
}