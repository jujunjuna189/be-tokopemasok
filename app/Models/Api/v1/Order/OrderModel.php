<?php

namespace App\Models\Api\v1\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $guarded = ['id'];
    protected $appends = ['qty'];

    protected function casts(): array
    {
        return [
            'qty' => 'double',
        ];
    }

    public function getQtyAttribute()
    {
        return OrderProductModel::where('order_number', $this->order_number)->sum('qty') ?? '0';
    }

    public function orderStatusModel()
    {
        return $this->hasMany(OrderStatusModel::class, 'order_number', 'order_number')->orderBy('id', 'desc')->limit(3);
    }

    public function orderProductModel()
    {
        return $this->hasMany(OrderProductModel::class, 'order_number', 'order_number')->with('orderProductHistoryModel', 'orderProductPriceHistoryModel');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($order) {
            $order->orderStatusModel()->delete();
        });
    }
}
