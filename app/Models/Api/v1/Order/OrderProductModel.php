<?php

namespace App\Models\Api\v1\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductModel extends Model
{
    use HasFactory;

    protected $table = 'order_product';
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'qty' => 'double',
        ];
    }

    public function orderModel()
    {
        return $this->hasOne(OrderModel::class, 'order_number', 'order_number');
    }

    public function orderProductHistoryModel()
    {
        return $this->hasOne(OrderProductHistoryModel::class, 'order_product_id', 'id');
    }

    public function orderProductPriceHistoryModel()
    {
        return $this->hasOne(OrderProductPriceHistoryModel::class, 'order_product_id', 'id');
    }
}
