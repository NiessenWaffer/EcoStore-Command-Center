<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\RegistrationTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    protected RegistrationTokenService $tokenService;

    public function __construct(RegistrationTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm(Request $request)
    {
        $token = $request->query('token');
        $email = '';

        if ($token) {
            $tokenRecord = $this->tokenService->validateToken($token);
            if ($tokenRecord && $tokenRecord->order_id) {
                $order = \App\Models\Order::find($tokenRecord->order_id);
                if ($order && isset($order->shipping_address['email'])) {
                    $email = $order->shipping_address['email'];
                }
            }
        }

        return view('auth.register', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'referral_code' => \Illuminate\Support\Str::random(10),
        ]);

        $token = $request->input('token');
        if ($token) {
            $this->tokenService->mergeGuestData($user, $token);
        }

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Welcome to the community! Your impact history has been saved.');
    }
}
