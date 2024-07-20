<?php

namespace App\Http\Controllers\Api\v1\Cart;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Api\v1\Cart\CartModel;
use App\Models\Api\v1\Cart\CartProductModel;
use App\Models\Api\v1\Product\ProductPriceModel;
use App\Models\Api\v1\User\UserAddressModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CartController extends BaseController
{
    public function get(Request $request)
    {
        $user = Auth::user();
        $cart = QueryBuilder::for(CartModel::where('user_id', $user->id))->allowedFilters([AllowedFilter::exact('id'), 'status'])->allowedIncludes(['cartProductModel'])->paginate()->appends(request()->query());
        return $this->successResponse('Success show data', [
            'cart' => $cart,
        ]);
    }

    public function create(Request $request)
    {
        // auth
        $user = Auth::user();
        // Get pricing product
        $product_price = ProductPriceModel::find($request->product_price_id);
        if (!$product_price) return $this->notFoundResponse('Product price tidak ditemukan', []);
        // get data cart active
        $cart = CartModel::with('cartProductModel')->firstOrNew(['user_id' => $user->id, 'status' => 'active']);
        if (is_null($cart->delivery)) $cart->delivery = 'Diantar Kerumah';
        if (is_null($cart->address)) $cart->address = UserAddressModel::where('user_id', $user->id)->first()->full_address ?? null;
        $cart->save();
        // Create cart product
        $cart_product = CartProductModel::firstOrNew(['cart_id' => $cart->id, 'product_id' => $request->product_id, 'product_price_id' => $request->product_price_id]);
        $cart_product->qty = !isset($request->qty) ? (isset($cart_product) ? $cart_product->qty + $product_price->qty : $product_price->qty) : $request->qty;
        $cart_product->save();
        // Delete data jika qty sama dengan 0
        if ($cart_product && isset($request->qty) && $request->qty == 0) {
            $cart_product->delete();
            if ($cart->cartProductModel->count() == 1) {
                $cart->delete();
            }
        }

        return $this->successResponse('Success buat data', [
            'cart' => CartModel::with('cartProductModel')->find($cart->id) ?? (object)[],
        ]);
    }

    public function update(Request $request)
    {
        $cart = CartModel::find($request->id);
        if (!$cart) return $this->notFoundResponse('Cart tidak ditemukan', []);

        $cart->fill($request->except('id'));
        $cart->save();

        return $this->successResponse('Success ubah data', [
            'cart' => CartModel::with('cartProductModel')->find($cart->id) ?? (object)[],
        ]);
    }

    public function delete(Request $request)
    {
        $cart = CartModel::find($request->id);
        if (!$cart) return $this->notFoundResponse('Cart tidak ditemukan', []);

        $cart->delete();
        return $this->successResponse('Success hapus data', [
            'cart' => $cart,
        ]);
    }
}
