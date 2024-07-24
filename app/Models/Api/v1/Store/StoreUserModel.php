<?php

namespace App\Models\Api\v1\Store;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreUserModel extends Model
{
    use HasFactory;

    protected $table = 'store_user';
    protected $guarded = ['id'];
}
