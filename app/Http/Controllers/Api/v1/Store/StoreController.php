<?php

namespace App\Http\Controllers\Api\v1\Store;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Api\v1\Store\StoreModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StoreController extends BaseController
{
    public function get(Request $request)
    {
        $store = QueryBuilder::for(StoreModel::class)->allowedFilters([AllowedFilter::exact('id'), 'domain'])->allowedIncludes([])->paginate()->appends(request()->query());

        return $this->successResponse('Success show data', [
            'store' => $store,
        ]);
    }

    public function create(Request $request)
    {
        $store = new StoreModel;
        $store->fill($request->except('id', 'image'));
        if ($request->has('image')) {
            $store_image = $this->upload_image($request, 'store', 'image');
            $store->image = $store_image;
        }
        $store->save();

        return $this->successResponse('Success buat data', [
            'store' => $store,
        ]);
    }

    public function update(Request $request)
    {
        $store = StoreModel::find($request->id);
        if (!$store) return $this->notFoundResponse('Toko tidak ditemukan', []);

        $store->fill($request->except('id', 'image'));
        if ($request->has('image')) {
            $store_image = $this->upload_image($request, 'store', 'image');
            $store->image = $store_image;
        }
        $store->save();

        return $this->successResponse('Success ubah data', [
            'store' => $store,
        ]);
    }

    public function delete(Request $request)
    {
        $store = StoreModel::find($request->id);
        if (!$store) return $this->notFoundResponse('Toko tidak ditemukan', []);

        $store->delete();
        return $this->successResponse('Success hapus data', [
            'store' => $store,
        ]);
    }
}
