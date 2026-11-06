<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Fortify::username('nik');

        // ❌ authenticateUsing DIHAPUS — biar Fortify pakai pipeline default
        // (yang otomatis cek 2FA sebelum login penuh)

        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();
        $this->configureResponses();   // <-- BARU
    }

    /**
     * Override response login agar balas JSON {two_factor, redirect}.
     */
    private function configureResponses(): void
    {
        // Login sukses TANPA 2FA
        $this->app->singleton(LoginResponseContract::class, function () {
            return new class implements LoginResponseContract {
                public function toResponse($request)
                {
                    if ($request->wantsJson()) {
                        return response()->json([
                            'two_factor' => false,
                            'redirect'   => '/main-dashboard',
                        ]);
                    }

                    return redirect()->intended('/main-dashboard');
                }
            };
        });

        // Login sukses TAPI butuh 2FA
        $this->app->singleton(TwoFactorLoginResponseContract::class, function () {
            return new class implements TwoFactorLoginResponseContract {
                public function toResponse($request)
                {
                    if ($request->wantsJson()) {
                        return response()->json([
                            'two_factor' => true,
                            'redirect'   => '/two-factor-challenge',
                        ]);
                    }

                    return redirect()->intended('/two-factor-challenge');
                }
            };
        });
    }

    private function configureActions(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::createUsersUsing(CreateNewUser::class);
    }

    private function configureViews(): void
    {
        Fortify::loginView(fn () => view('livewire.auth.login'));
        Fortify::verifyEmailView(fn () => view('livewire.auth.verify-email'));
        Fortify::twoFactorChallengeView(fn () => view('livewire.auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn () => view('livewire.auth.confirm-password'));
        Fortify::registerView(fn () => view('livewire.auth.register'));
        Fortify::resetPasswordView(fn () => view('livewire.auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn () => view('livewire.auth.forgot-password'));
    }

    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });
    }
}