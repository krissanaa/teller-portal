<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = $this->findUserByIdentifier($data['identifier']);

        if (! $user || ! Hash::check($data['password'], (string) $user->password)) {
            if (! $request->expectsJson()) {
                return redirect()->route('login')
                    ->withErrors(['identifier' => __('auth.failed')])
                    ->withInput($request->only('identifier'));
            }

            throw ValidationException::withMessages([
                'identifier' => [__('auth.failed')],
            ]);
        }

        if (! $user->canLogin()) {
            if (! $request->expectsJson()) {
                return redirect()->route('login')
                    ->withErrors(['identifier' => __('Your account is not approved yet.')]);
            }

            return response()->json([
                'message' => __('Your account is not approved yet.'),
                'status' => $user->status,
            ], 403);
        }

        // Rehash to lower bcrypt cost for future logins (honors BCRYPT_ROUNDS env)
        $rounds = (int) env('BCRYPT_ROUNDS', 10);
        if (Hash::needsRehash($user->password, ['rounds' => $rounds])) {
            $user->forceFill([
                'password' => Hash::make($data['password'], ['rounds' => $rounds]),
            ])->save();
        }

        $token = $user->createToken('api-token', [$user->role])->plainTextToken;

        if (! $request->expectsJson()) {
            return redirect()->intended(route('teller.dashboard'))
                ->cookie('api_token', $token, 60 * 24);
        }

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            // Do not eager load relations here; keep response lean for login
            'user' => new UserResource($user),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'message' => __('Logged out successfully.'),
        ]);
    }

    public function me(Request $request)
    {
        return new UserResource($request->user()->loadMissing(['branch', 'unit']));
    }

    protected function findUserByIdentifier(string $identifier): ?User
    {
        $field = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'teller_id';

        return User::query()
            ->select([
                'id',
                'name',
                'email',
                'teller_id',
                'password',
                'role',
                'status',
                'branch_id',
                'unit_id',
            ])
            ->where($field, $identifier)
            ->first();
    }
}
