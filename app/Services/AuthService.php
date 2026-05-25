<?php

namespace App\Services;

use App\Models\UserModel;
use App\Entities\User;

class AuthService
{
    protected UserModel $users;

    public function __construct()
    {
        $this->users = new UserModel();
    }

    public function attemptLogin (string $email, string $password): bool
    {
        $user = $this->users->where('email', $email)->first();

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            return false;
        }

        session()->set([
            'user_id' => $user->id,
            'name' => $user->name,
            'user_role' => $user->role,
            'is_logged_in' => true,
        ]);

        return true;
    }

    public function logout() : void
    {
        session()->destroy();
    }

    public function register(array $data): bool
    {
        $userModel = new UserModel();

        $user = new User();
        $user->name = $data['name'];
        $user->email    = $data['email'];

        $user->password = password_hash($data['password'], PASSWORD_BCRYPT);

        $user->role     = 'writer';

        return $userModel->save($user);
    }
}