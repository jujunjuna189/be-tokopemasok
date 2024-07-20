<?php

namespace App\Models\Api\v1\Cart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $guarded = ['id'];
    protected $appends = ['qty', 'sub_total'];

    protected function casts(): array
    {
        return [
            'qty' => 'double',
        ];
    }

    public function getQtyAttribute()
    {
        return CartProductModel::where('cart_id', $this->id)->sum('qty') ?? '0';
    }

    public function getSubTotalAttribute()
    {
        $cart_product_model = CartProductModel::where('cart_id', $this->id)->get();
        $sub_total = [];
        foreach ($cart_product_model as $val) {
            $sub_total[] = $val->productPriceModel->price * $val->qty;
        }
        return (string) array_sum($sub_total);
    }

    public function cartProductModel()
    {
        return $this->hasMany(CartProductModel::class, 'cart_id', 'id')->with('productModel', 'productPriceModel');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($cart) {
            $cart->cartProductModel()->delete();
        });
    }
}
