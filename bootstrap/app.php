<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            /**** OTHER MIDDLEWARE ALIASES ****/
            'set_locale'              => App\Http\Middleware\SetLocale::class, // defined to make mcamara/laravel-localization work with livewire components
            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
        ]);

        // $middleware->redirectGuestsTo(fn(Request $request) => route('selection'));
        $middleware->redirectGuestsTo(function ($request) {
            if (!$request->expectsJson()) {
                if (Request::is(app()->getLocale() . '/student/dashboard')) {
                    session()->forget('url.intended');
                    return route('selection');
                } elseif (Request::is(app()->getLocale() . '/teacher/dashboard')) {
                    session()->forget('url.intended');
                    return route('selection');
                } elseif (Request::is(app()->getLocale() . '/parent/dashboard')) {
                    session()->forget('url.intended');
                    return route('selection');
                } else {
                    session()->forget('url.intended');
                    return route('selection');
                }
            }
        });

        $middleware->redirectUsersTo(function ($request) {
            $redirects = [
                'web' => route('dashboard', app()->getLocale()),
                'student' => route('student.dashboard', app()->getLocale()),
                'teacher' => route('teacher.dashboard', app()->getLocale()),
                'parent' => route('parent.dashboard', app()->getLocale()),
                'admin' => route('dashboard', app()->getLocale()),
            ];

            foreach (array_keys($redirects) as $guard) {
                if (auth($guard)->check()) {
                    return redirect($redirects[$guard]);
                }
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
