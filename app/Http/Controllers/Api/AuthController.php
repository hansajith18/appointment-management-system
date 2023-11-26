<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    final public function login(Request $request): Response
    {
        try {
            $fields = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required'
            ]);
            $fields['email'] = $fields['email'] ?? null;
            $source = $request->source ? (int)$request->source : 0;

        } catch (ValidationException $e) {
            $errors = $e->errors();
            $errors = reset($errors)[0];
            return response([
                'success' => false,
                'message' => $errors,
                'data' => null,
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('email', $fields['email'])->first();

        if (!$user) {
            return response([
                'success' => false,
                'message' => 'User does not exists, Please check your email or phone number and try again.!',
                'data' => null,
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $isValidPassword = Hash::check($fields['password'], $user->password);

        if (!$isValidPassword) {
            Log::error(
                'Bad Credentials, User not authorized | USER LOGIN ATTEMPT BY: ' . '[' . $source . '] ',
                $user->only(['external_patient_id', 'email', 'username'])
            );
            return response([
                'success' => false,
                'message' => 'Bad Credentials, You are not authorized.',
                'data' => null,
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $accessToken = $user->createToken('accessToken')->plainTextToken;
        Log::info(
            'SUCCESSFULLY LOGGED IN | USER LOGGED IN BY: ' . '[' . $source . '] ',
            $user->only(['external_patient_id', 'email', 'username'])
        );
        return response([
            'success' => true,
            'message' => 'Successfully logged in..!',
            'data' => collect($user->only(['id', 'name', 'email']))->put('token', $accessToken),
        ], ResponseAlias::HTTP_OK);
    }
}
