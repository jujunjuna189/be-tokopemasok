<?php

namespace App\Http\Controllers\Api\v1\Order;

use App\Http\Controllers\Api\BaseController;
use App\Models\Api\v1\Order\OrderModel;
use App\Models\Api\v1\Order\OrderStatusModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderStatusController extends BaseController
{
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $order_status = new OrderStatusModel;
            $order_status->fill($request->except('id'));
            $order_status->save();

            if ($order_status->status == 'cancelled') {
                $order = OrderModel::where('order_number', $order_status->order_number)->first();
                $order->status = "done";
                $order->save();
            }

            DB::commit();
            return $this->successResponse('Success buat data', [
                'order_status' => $order_status,
            ]);
        } catch (Exception $e) {
            logs($e->getMessage());
            DB::rollback();
            return $e;
        }
    }
}
