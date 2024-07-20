<?php

namespace App\Models\Api\v1\Cart;

use App\Models\Api\v1\Product\ProductModel;
use App\Models\Api\v1\Product\ProductPriceModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProductModel extends Model
{
    use HasFactory;

    protected $table = 'cart_product';
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'qty' => 'double',
        ];
    }

    public function cartModel()
    {
        return $this->hasOne(CartModel::class, 'id', 'cart_id');
    }

    public function productModel()
    {
        return $this->hasOne(ProductModel::class, 'id', 'product_id');
    }

    public function productPriceModel()
    {
        return $this->hasOne(ProductPriceModel::class, 'id', 'product_price_id');
    }
}
