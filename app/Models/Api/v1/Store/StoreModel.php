<?php

namespace App\Models\Api\v1\Store;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreModel extends Model
{
    use HasFactory;

    protected $table = 'store';
    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        return !is_null($value) ? url('') . "/$value" : null;
    }
}
