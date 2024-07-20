<?php

namespace App\Models\Api\v1\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        return !is_null($value) ? url('') . "/$value" : null;
    }

    public function getCategoryAttribute($value)
    {
        return json_decode($value);
    }

    public function price()
    {
        return $this->hasOne(ProductPriceModel::class, 'product_id', 'id');
    }

    public function productPriceModel()
    {
        return $this->hasMany(ProductPriceModel::class, 'product_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($product) {
            $product_image = parse_url($product->image);
            File::delete(public_path($product_image['path']));
            $product->productPriceModel()->delete();
        });
    }
}
