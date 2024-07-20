<?php

namespace App\Models\Api\v1\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddressModel extends Model
{
    use HasFactory;

    protected $table = 'users_address';
    protected $guarded = ['id'];
}
