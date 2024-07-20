<?php

namespace App\Models\Api\v1\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'users';
    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static $getRules = [
        'name' => ['required'],
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    public static $storeRules = [
        'name' => ['string', 'max:100'],
        'email' => ['required', 'email', 'unique:users'],
        'password' => ['required', 'min:6'],
    ];

    public static $messageRules = [
        'required' => ':attribute harus diisi',
        'email' => 'Input harus berupa email',
        'string' => 'Input harus berupa teks',
        'name.max' => ':attribute maximal 100 karakter',
        'password.min' => ':attribute minimal 6 karakter',
        'unique' => ':attribute sudah digunakan',
    ];

    public function userAddressModel()
    {
        return $this->hasMany(UserAddressModel::class, 'user_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->userAddressModel()->delete();
        });
    }
}
