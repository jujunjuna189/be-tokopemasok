<?php

namespace App\Models\Api\v1\Store;

use App\Models\Api\v1\Product\ProductModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProductModel extends Model
{
    use HasFactory;

    protected $table = 'store_product_model';
    protected $guarded = ['id'];

    public function product()
    {
        return $this->hasOne(ProductModel::class, 'id', 'product_id');
    }
}
