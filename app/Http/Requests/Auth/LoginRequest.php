<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Lang;

class LoginRequest extends FormRequest
{
    protected $id_type;
    protected function prepareForValidation()
    {
        if (filter_var($this->input('id_user'), FILTER_VALIDATE_EMAIL)) {
            $this->id_type = 'email';
        } else {
            $this->id_type = 'username';
        }
        $this->merge([
            $this->id_type => $this->input('id_user'),
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_user' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Coba login menggunakan guard "web"
        if (Auth::guard('web')->attempt($this->only($this->id_type, 'password'), $this->boolean('remember'))) {
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // Jika login dengan guard "web" tidak berhasil, coba menggunakan guard "wali"
        if (Auth::guard('wali')->attempt($this->only($this->id_type, 'password'), $this->boolean('remember'))) {
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // Jika kedua percobaan gagal, tangani seperti yang Anda lakukan sebelumnya
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'id_user' => trans('auth.failed'),
        ]);
    }

    protected function handleFailedLoginAttempt($guard)
    {
        RateLimiter::hit($this->throttleKey($guard));

        throw ValidationException::withMessages([
            'id_user' => Lang::get('auth.failed'),
        ])->status(429); // Set kode status HTTP menjadi 429 (Too Many Requests)
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 2)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'id_user' => Lang::get('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ])->status(429); // Set kode status HTTP menjadi 429 (Too Many Requests)
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input($this->id_type)) . '|' . $this->ip());
    }


}
