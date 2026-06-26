<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;

final class AuthController
{
    public function login(): void
    {
        if (Auth::check()) {
            redirect('/admin');
        }

        view('admin/login', ['error' => $_SESSION['login_error'] ?? null]);
        unset($_SESSION['login_error']);
    }

    public function authenticate(): void
    {
        Csrf::verify($_POST['_csrf'] ?? null);
        $password = (string) ($_POST['password'] ?? '');

        if (!Auth::attempt($password)) {
            $_SESSION['login_error'] = 'كلمة السر غير صحيحة.';
            redirect('/admin/login');
        }

        redirect('/admin');
    }

    public function logout(): void
    {
        Csrf::verify($_POST['_csrf'] ?? null);
        Auth::logout();
        redirect('/admin/login');
    }
}
