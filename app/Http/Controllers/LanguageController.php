<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(string $locale, Request $request): RedirectResponse
    {
        if (! in_array($locale, ['en', 'tr', 'ru'], true)) {
            abort(404);
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);

        $redirect = $request->query('redirect', url()->previous());

        if (! is_string($redirect) || $redirect === '') {
            $redirect = route('home');
        }

        return redirect()->to($redirect);
    }
}
