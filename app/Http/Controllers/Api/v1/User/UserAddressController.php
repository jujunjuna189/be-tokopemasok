<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Api\v1\User\UserAddressModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserAddressController extends BaseController
{
    public function get(Request $request)
    {
        $user = Auth::user();
        $user_address = QueryBuilder::for(UserAddressModel::class)->where(['user_id' => $user->id])->allowedFilters([AllowedFilter::exact('id')])->allowedIncludes([])->paginate()->appends(request()->query());

        return $this->successResponse('Success show data', [
            'user_address' => $user_address,
        ]);
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $user_address = new UserAddressModel;
        $user_address->fill($request->except('id', 'user_id'));
        $user_address->user_id = $user->id;
        $user_address->save();

        return $this->successResponse('Success buat data', [
            'user_address' => $user_address,
        ]);
    }

    public function update(Request $request)
    {
        $user_address = UserAddressModel::find($request->id);
        if (!$user_address) return $this->notFoundResponse('User address tidak ditemukan', []);

        $user_address->fill($request->except('id'));
        $user_address->save();

        return $this->successResponse('Success ubah data', [
            'user_address' => $user_address,
        ]);
    }

    public function delete(Request $request)
    {
        $user_address = UserAddressModel::find($request->id);
        if (!$user_address) return $this->notFoundResponse('User address tidak ditemukan', []);

        $user_address->delete();
        return $this->successResponse('Success hapus data', [
            'user_address' => $user_address,
        ]);
    }
}
