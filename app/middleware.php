<?php
function auth_middleware()
{
    if (!auth()->check()) {
        request()->redirect('/login');
    }
}
function auth_admin_middleware()
{
    $user = auth()->user();
    if (auth()->check()) {
        if ($user->user_type != "admin") {
            echo view('site/errors/404');
            die();
        }
    } else {
        request()->redirect('/login');
    }
}
