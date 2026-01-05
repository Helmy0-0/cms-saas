<?php

namespace App\Controllers;

use App\Services\ArticleService;

class DashboardController extends BaseController
{
    protected ArticleService $articleService;

    public function __construct()
    {
        $this->articleService = new ArticleService();
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
            'role' => $role
        ];

        return view('dashboard/index', $data);
    }

    public function create()
    {
        return view('dashboard/create');
    }
}