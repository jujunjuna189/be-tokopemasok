<?php

namespace App\Models\Api\v1\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPriceModel extends Model
{
    use HasFactory;

    protected $table = 'product_price';
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'price' => 'string',
            'stock' => 'int',
            'qty' => 'double',
        ];
    }
}
