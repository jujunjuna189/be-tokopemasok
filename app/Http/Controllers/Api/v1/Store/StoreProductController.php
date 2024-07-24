<?php

namespace App\Http\Controllers\Api\v1\Store;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Api\v1\Store\StoreProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StoreProductController extends BaseController
{
    public function get(Request $request)
    {
        $store_product = QueryBuilder::for(StoreProductModel::class)->allowedFilters([AllowedFilter::exact('id'), AllowedFilter::exact('product_id')])->allowedIncludes([])->paginate()->appends(request()->query());

        return $this->successResponse('Success show data', [
            'store_product' => $store_product,
        ]);
    }

    public function create(Request $request)
    {
        $store_product = new StoreProductModel;
        $store_product->fill($request->except('id'));
        $store_product->save();

        return $this->successResponse('Success buat data', [
            'store_product' => $store_product,
        ]);
    }

    public function update(Request $request)
    {
        $store_product = StoreProductModel::find($request->id);
        if (!$store_product) return $this->notFoundResponse('Produk Toko tidak ditemukan', []);

        $store_product->fill($request->except('id'));
        $store_product->save();

        return $this->successResponse('Success ubah data', [
            'store_product' => $store_product,
        ]);
    }

    public function delete(Request $request)
    {
        $store_product = StoreProductModel::find($request->id);
        if (!$store_product) return $this->notFoundResponse('Produk Toko tidak ditemukan', []);

        $store_product->delete();
        return $this->successResponse('Success hapus data', [
            'store_product' => $store_product,
        ]);
    }
}
