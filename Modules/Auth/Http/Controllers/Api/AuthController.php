<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Modules\Auth\Emails\PasswordResetMail;
use Modules\Auth\Emails\VerificationMail;
use Modules\Auth\Entities\PasswordReset;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Transformers\UserResource;

class AuthController extends Controller
{
    public function register(RegisterRequest $registerRequest)
    {
        try {
            $registerRequest['status'] = '1';
            $registerRequest['password'] = Hash::make($registerRequest['password']);
            // $registerRequest['fcm_token'] = $registerRequest->fcm_token;

            $user = User::create($registerRequest->all());

            $token = $user->createToken('register')->plainTextToken;

            return api_response_success([
                'token' => $token,
                'user' => new UserResource($user),
            ]);
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return api_response_error();
        }
    }
    public function login(LoginRequest $loginRequest)
    {
        $user = User::where('email', $loginRequest->email)->first();
        if ($user) {
            if ($user->status == 0) {
                return api_response_error(__('auth::common.account_closed'));
            }
            if (Hash::check($loginRequest->password, $user->password)) {
                $user->update([
                    'fcm_token' => $loginRequest->fcm_token,
                ]);
                $token = $user->createToken('login')->plainTextToken;

                return api_response_success([
                    'token' => $token,
                    'user' => new UserResource($user),
                ]);
            } else {
                return api_response_error(__('auth::common.password_mismatch'));
            }

        } else {
            return api_response_error(__('auth::common.data_check_failed'));
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return api_response_success(__('auth::common.logout_successful'));
    }

    public function resendCode(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
        ], [], [
            'email' => __('auth::common.email'),
        ]);

        if ($validation->fails()) {
            return api_response_error($validation->errors()->first());
        }

        $user = User::where('email', $request->email)->first();

        $code = rand(100000, 999999);

        $user->update([
            'code' => $code,
        ]);

        Mail::to($user->email)->send(new VerificationMail($user));

        return api_response_success(__('auth::common.verification_code_sent'));
    }

    public function forget_password(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
        ], [], [
            'email' => __('auth::common.email'),
        ]);

        if ($validation->fails()) {
            return api_response_error($validation->errors()->first());
        }

        $user = User::where('email', $request->email)->first();

        $code = rand(100000, 999999);

        if (!$userpassreset = PasswordReset::where('email', $user->email)->first()) {
            $userpassreset = PasswordReset::create([
                'email' => $user->email,
                'token' => $code,
            ]);
        } else {
            $userpassreset->where('email', $user->email)->update([
                'token' => $code,
            ]);
        }

        Mail::to($user->email)->send(new PasswordResetMail($code));

        return api_response_success(__('auth::common.verification_code_sent'));
    }

    public function change_password(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => ['required', 'exists:users,email'],
            'token' => ['required'],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ],
        ], [], [
            'email' => __('auth::common.email'),
            'token' => __('auth::common.verification_code'),
            'password' => __('auth::common.new_password'),
        ]);

        if ($validation->fails()) {
            return api_response_error($validation->errors()->first());
        }

        $user = User::where('email', $request['email'])->first();

        if (!$user) {
            return api_response_error(__('auth::common.no_matching_data'));
        }

        $resetRequest = PasswordReset::where('email', $request['email'])->first();

        if (!$resetRequest || $resetRequest->token != $request['token']) {
            return api_response_error(__('auth::common.invalid_verification_code'));
        }
        $user->update([
            'password' => Hash::make($request['password']),
        ]);

        PasswordReset::where('email', $request['email'])->delete();

        $token = $user->createToken('login')->plainTextToken;

        return api_response_success([
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    public function change_password_logged(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'old_password' => ['required'],
            'password' => ['required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed'],
        ], [], [
            'old_password' => __('auth::common.old_password'),
            'password' => __('auth::common.new_password'),
        ]);

        if ($validation->fails()) {
            return api_response_error($validation->errors()->first());
        }

        $user = User::where('id', sanctum()->id())->first();

        if (Hash::check($request->old_password, $user->password)) {

            $user->update([
                'password' => Hash::make($request['password']),
            ]);

            return api_response_success([
                'user' => new UserResource($user),
            ]);

        } else {
            return api_response_error(__('auth::common.password_mismatch'));
        }
    }

    public function logged_user()
    {
        $user = User::where('id', sanctum()->id())->first();
        $data = new UserResource($user);
        try {
            return api_response_success($data);
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }

    public function delete_account()
    {
        try {
            $user = User::where('id', sanctum()->id())->first();
            $user->delete();
            return api_response_success('Account deleted successfully');
        } catch (\Throwable $th) {
            return api_response_error();
        }
    }
}
