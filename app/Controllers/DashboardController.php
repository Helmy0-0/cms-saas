<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Services\ArticleService;

class DashboardController extends BaseController
{
    protected ArticleService $articleService;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->articleService = new ArticleService();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $role = session()->get('user_role');

        if ($role === 'admin' || $role === 'editor') {
            $articles = $this->articleService->getAllArticles();
        } else {
            $articles = $this->articleService->getArticlesByAuthor($userId);
        }

        $data = [
            'articles' => $articles,
            'role' => $role,
            'users' => $role === 'admin' ? $this->userModel->orderBy('created_at', 'DESC')->findAll() : [], 
            'selectedUser' => null,
        ];

        return view('dashboard/index', $data);
    }

    public function userArticles($userId)
    {
        $role           = session()->get('user_role');
        $selectedUser   = $this->userModel->find((int) $userId);

        if (!$selectedUser){
            return redirect()->to('/dashboard')->with('error', 'User Not Found');
        }

        $articles = $this->articleService->getArticlesByAuthor((int) $userId);

        $data = [
            'articles'      => $articles,
            'role'          => $role,
            'users'         => $role === 'admin' ? $this->userModel->orderBy('created_at', 'DESC')->findAll() : [], 
            'selectedUser' => $selectedUser,
        ];

        return view('dashboard/index', $data);
    }

    public function updateUserRole($userId)
    {
        $newRole        = (string) $this->request->getPost('role');
        $allowedRoles   = ['writer', 'editor', 'admin'];

        if (!in_array($newRole, $allowedRoles, true)) {
            return redirect()->to('/dashboard')->with('error', 'invalid role selected');
        }

        $targetUser = $this->userModel->find((int) $userId);

        if (!$targetUser) {
            return redirect()->to('/dashboard')->with('error', 'user not found');
        }

        $this->userModel->update((int) $userId, ['role' => $newRole]);
        return redirect()->to('/dashboard')->with('success', 'user role updated');
    }

    public function create()
    {
        return view('dashboard/create');
    }
}