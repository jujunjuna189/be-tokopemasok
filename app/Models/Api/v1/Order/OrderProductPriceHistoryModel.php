<?php

namespace App\Models\Api\v1\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductPriceHistoryModel extends Model
{
    use HasFactory;

    protected $table = 'order_product_price_history';
    protected $guarded = [];

    protected $primaryKey = null;
    public $incrementing = false;

    protected function casts(): array
    {
        return [
            'price' => 'string',
        ];
    }
}
