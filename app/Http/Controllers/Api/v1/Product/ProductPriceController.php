<?php

namespace App\Http\Controllers\Api\v1\Product;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Api\v1\Product\ProductPriceModel;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProductPriceController extends BaseController
{
    public function get(Request $request)
    {
        $product_price = QueryBuilder::for(ProductPriceModel::class)->get();

        return $this->successResponse('Success show data', [
            'product_price' => $product_price,
        ]);
    }

    public function create(Request $request)
    {
        $product_price = new ProductPriceModel;
        $product_price->fill($request->all());
        $product_price->save();

        return $this->successResponse('Success buat data', [
            'product_price' => $product_price,
        ]);
    }

    public function update(Request $request)
    {
        $product_price = ProductPriceModel::find($request->id);
        if (!$product_price) return $this->notFoundResponse('Harga produk tidak ditemukan', []);

        $product_price->fill($request->all());
        $product_price->save();

        return $this->successResponse('Success ubah data', [
            'product_price' => $product_price,
        ]);
    }

    public function delete(Request $request)
    {
        $product_price = ProductPriceModel::find($request->id);
        if (!$product_price) return $this->notFoundResponse('Harga produk tidak ditemukan', []);

        $product_price->delete();
        return $this->successResponse('Success hapus data', [
            'product_price' => $product_price,
        ]);
    }
}
