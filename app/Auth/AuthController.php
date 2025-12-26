<?php

namespace App\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

use App\Http\Controllers\Controller;
use App\Auth\Requests\LoginRequest;
use App\Auth\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login user and return JWT token
     * 
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @unauthenticated
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password_hash)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        $accessToken = $guard->fromUser($user);

        return response()->json([
            'access_token' => $accessToken,
            'token_type'   => 'Bearer',
            'expires_in'   => $guard->factory()->getTTL() * 60,
        ]);
    }

    /**
     * Register user and return JWT token
     * 
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @unauthenticated
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
        ]);

        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        $accessToken = $guard->fromUser($user);

        return response()->json([
            'access_token' => $accessToken,
            'token_type'   => 'Bearer',
            'expires_in'   => $guard->factory()->getTTL() * 60,
        ]);
    }

    /**
     * Get user profile
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        return response()->json($guard->user());
    }

    /**
     * Logout user (Invalidate token)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        $guard->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh JWT token
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        $refreshToken = $guard->refresh();
        return $this->respondWithToken($refreshToken);
    }

    /**
     * Return token response structure
     * 
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        /** @var \PHPOpenSourceSaver\JWTAuth\JWTGuard $guard */
        $guard = auth('api');
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $guard->factory()->getTTL() * 60,
        ]);
    }
}
