<?php

namespace App\Models\Api\v1\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusModel extends Model
{
    use HasFactory;

    protected $table = 'order_status';
    protected $guarded = ['id'];
}
