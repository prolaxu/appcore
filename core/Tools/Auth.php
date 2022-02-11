<?php

namespace core\Tools;

use core\Tools\DB;

class Auth
{
    public function login()
    {
        $db = new DB();
        $user = $db->table('users')->where(['email' => $_POST['email']])->firstArray();
        if ($user) {
            if (md5($_POST['password']) == $user["password"]) {
                $_SESSION['user'] = (object) $user;
                return (object)['is_logged' => true, "message" => "Successfully logged in.", "user" => $user];
            } else {
                setError('password', "Password is incorrect.");
                return (object) ['is_logged' => false, "message" => "Wrong password."];
            }
        } else {
            setError('email', "User not found.");
            return (object) ['is_logged' => false, "message" => "User not found."];
        }
    }
    public function register()
    {
        $db = new DB();
        $user = $db->table('users');
        $err = [];
        $user->exists(['email' => $_POST['email']]) ? $err['email'] = "Email already exists." : null;
        $_POST['name'] ?: $err['name'] = "Name is required.";
        $_POST['email'] ?: $err['email'] = "Email is required.";
        $_POST['phone'] ?: $err['phone'] = "Phone is required.";
        $_POST['password'] != $_POST['conform_password'] ? $err['password'] = "Password and password confirmation does not match." : null;
        if ($err == []) {
            $userData = $user->insert([
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'password' => md5($_POST['password']),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $_SESSION['user'] = $userData;
            return (object) ['is_logged' => true, "message" => "Successfully registered.", "user" => $userData];
        } else {
            $_SESSION['errors'] = $err;
            return $err;
        }
    }
    public function logout()
    {
        session_destroy();
    }
    public function check()
    {
        if (isset($_SESSION['user'])) {
            return true;
        }
        return false;
    }
    public function user()
    {
        return $_SESSION['user'] ?? null;
    }
    public function update()
    {
        $db = new DB();
        return $_SESSION['user'] = $db->table('users')->find($_SESSION['user']->id);
    }
}
