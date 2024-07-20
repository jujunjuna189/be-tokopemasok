<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Models\Api\v1\User\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Function for login
     * @param email
     * @param password
     */
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => UserModel::$getRules['email'],
                'password' => UserModel::$getRules['password']
            ],
            UserModel::$messageRules
        );

        if ($validator->fails()) {
            return $this->badRequestResponse($validator->messages());
        }

        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->unAuthorizationResponse('Login gagal');
        }

        $user = UserModel::where('email', $request->email)->first();
        if (!Hash::check($request->password, $user->password)) {
            return $this->badRequestResponse('Login gagal');
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return $this->successResponse('Berhasil masuk akun', [
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * Function for register or store user
     * @param name
     * @param email
     * @param password
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), UserModel::$storeRules, UserModel::$messageRules);
        if ($validator->fails()) {
            return $this->badRequestResponse($validator->messages());
        }

        $user = new UserModel();
        $user->fill($request->except('password'));
        $user->password = Hash::make($request->password);
        $user->save();

        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->unAuthorizationResponse('Credential gagal');
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return $this->successResponse('Berhasil daftar akun', [
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * Function for register or store user from google akun
     * @param name
     * @param email
     */
    public function registerGoogle(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => UserModel::$getRules['email']
            ],
            UserModel::$messageRules
        );
        if ($validator->fails()) {
            return $this->badRequestResponse($validator->messages());
        }

        $user = UserModel::firstOrNew(['email' => $request->email]);
        $user->photo = $request->photo;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make('google');
        $user->email_verified_at = Carbon::now();
        $user->save();

        $credentials = ['email' => $user->email, 'password' => 'google'];

        if (!Auth::attempt($credentials)) {
            return $this->unAuthorizationResponse('Credential gagal');
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return $this->successResponse('Berhasil daftar akun', [
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }
}
