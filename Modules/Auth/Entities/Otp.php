<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class Otp extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

 
    public function user()
    {
    return $this->belongsTo(User::class);
    }
}
