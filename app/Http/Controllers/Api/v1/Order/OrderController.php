<?php

namespace App\Http\Controllers\Api\v1\Order;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\v1\Public\BaseOrderController;
use App\Models\Api\v1\Cart\CartModel;
use App\Models\Api\v1\Order\OrderModel;
use App\Models\Api\v1\Order\OrderProductHistoryModel;
use App\Models\Api\v1\Order\OrderProductModel;
use App\Models\Api\v1\Order\OrderProductPriceHistoryModel;
use App\Models\Api\v1\Order\OrderStatusModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends BaseController
{
    public function get(Request $request)
    {
        $user = Auth::user();
        $order = QueryBuilder::for(OrderModel::where('user_id', $user->id))->allowedFilters([AllowedFilter::exact('id'), 'order_number', 'status'])->allowedIncludes(['orderStatusModel', 'orderProductModel'])->allowedSorts(['id'])->paginate()->appends(request()->query());
        return $this->successResponse('Success show data', [
            'order' => $order,
        ]);
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            // get order number
            $orderNumber = BaseOrderController::createOrderNumber();
            // Get data cart
            $cart = CartModel::find($request->cart_id);
            if (!$cart) return $this->notFoundResponse('Cart tidak ditemukan', []);
            // Create order
            $order = new OrderModel;
            $order->fill(Arr::except($cart->toArray(), ['order_number', 'total', 'created_at', 'updated_at']));
            $order->order_number = $orderNumber;
            $order->total = $cart->sub_total;
            $order->status = 'processed';
            $order->save();
            // Create order status
            $order_status = new OrderStatusModel;
            $order_status->order_number = $orderNumber;
            $order_status->status = $order->status;
            $order_status->description = "Pesanan Anda sudah kami terima dan sedang dalam proses";
            $order_status->save();
            // Create order product
            foreach ($cart->cartProductModel as $val) {
                // Create order product
                $orderProduct = new OrderProductModel;
                $orderProduct->fill(Arr::except($val->toArray(), ['order_number', 'created_at', 'updated_at']));
                $orderProduct->order_number = $orderNumber;
                $orderProduct->save();
                // Create product history for order
                $orderProductHistory = new OrderProductHistoryModel;
                $orderProductHistory->fill(Arr::except($val->productModel->toArray(), ['order_product_id', 'order_number', 'id', 'created_at', 'updated_at']));
                $orderProductHistory->order_product_id = $orderProduct->id;
                $orderProductHistory->order_number = $orderNumber;
                $orderProductHistory->id = $orderProduct->product_id;
                $orderProductHistory->save();
                // Create product price history for order
                $orderProductPriceHistory = new OrderProductPriceHistoryModel;
                $orderProductPriceHistory->fill(Arr::except($val->productPriceModel->toArray(), ['order_product_id', 'order_number', 'id', 'created_at', 'updated_at']));
                $orderProductPriceHistory->order_product_id = $orderProduct->id;
                $orderProductPriceHistory->order_number = $orderNumber;
                $orderProductPriceHistory->id = $orderProduct->product_price_id;
                $orderProductPriceHistory->save();
            }
            // if cart move to order then delete cart data
            $cart->delete();

            DB::commit();
            return $this->successResponse('Success buat data', [
                'order' => $order,
            ]);
        } catch (Exception $e) {
            logs($e->getMessage());
            DB::rollback();
            return $e;
        }
    }

    public function delete(Request $request)
    {
        $order = OrderModel::find($request->id);
        if (!$order) return $this->notFoundResponse('Order tidak ditemukan', []);

        $order->delete();
        return $this->successResponse('Success hapus data', [
            'order' => $order,
        ]);
    }
}
