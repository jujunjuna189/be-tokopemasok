<?php

namespace App\Http\Controllers\Api\v1\Product;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Api\v1\Product\ProductModel;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends BaseController
{
    public function get(Request $request)
    {
        $product = QueryBuilder::for(ProductModel::class)->allowedFilters([AllowedFilter::exact('id')])->allowedIncludes(['price'])->paginate()->appends(request()->query());

        return $this->successResponse('Success show data', [
            'product' => $product,
        ]);
    }

    public function create(Request $request)
    {
        $product = new ProductModel;
        $product->fill($request->except('image'));
        if ($request->has('image')) {
            $product_image = $this->upload_image($request, 'product', 'image');
            $product->image = $product_image;
        }
        $product->save();

        return $this->successResponse('Success buat data', [
            'product' => $product,
        ]);
    }

    public function update(Request $request)
    {
        $product = ProductModel::find($request->id);
        if (!$product) return $this->notFoundResponse('Produk tidak ditemukan', []);
        // dd($product);

        $product->fill($request->except('image'));
        if ($request->has('image')) {
            $product_image = $this->upload_image($request, 'product', 'image');
            $product->image = $product_image;
        }
        $product->save();

        return $this->successResponse('Success ubah data', [
            'product' => $product,
        ]);
    }

    public function delete(Request $request)
    {
        $product = ProductModel::find($request->id);
        if (!$product) return $this->notFoundResponse('Produk tidak ditemukan', []);

        $product->delete();
        return $this->successResponse('Success hapus data', [
            'product' => $product,
        ]);
    }
}
