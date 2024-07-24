<?php

namespace App\Models\Api\v1\Store;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreModel extends Model
{
    use HasFactory;

    protected $table = 'store_model';
    protected $guarded = ['id'];

    public function storeProductModel()
    {
        return $this->hasMany(StoreProductModel::class, 'store_id', 'id');
    }
}
