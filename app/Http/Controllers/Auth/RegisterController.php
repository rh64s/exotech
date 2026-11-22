<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Register a new user and sign them in.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $role = Role::firstWhere(['name' => 'client']);

        $user = User::create([
            ...$request->validated(),
            'role_id' => $role->id,
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('home');
    }
}
