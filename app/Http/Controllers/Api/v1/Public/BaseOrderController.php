<?php

namespace App\Http\Controllers\Api\v1\Public;

use App\Models\Api\v1\Order\OrderModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BaseOrderController
{
    static public function createOrderNumber()
    {
        // contant
        $constDate = Carbon::now()->format('dmy');
        // Get las order
        $order = OrderModel::orderBy('id', 'desc')->first();
        $number = '0001';

        if (isset($order) && explode('-', $order->order_number)[1] == $constDate) {
            $numberData = (int) explode('-', $order->order_number)[2];
            $numberData = str_pad($numberData + 1, 4, '0', STR_PAD_LEFT);
            $number = $numberData;
        }

        $orderNumber = 'INV';
        // Create number from date
        $orderNumber .= '-';
        $orderNumber .= $constDate;
        $orderNumber .= '-';
        $orderNumber .= $number;

        return $orderNumber;
    }
}
