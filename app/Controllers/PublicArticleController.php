<?php

namespace App\Controllers;

use App\Services\ArticleService;

class PublicArticleController extends BaseController
{
    protected ArticleService $articleService;

    public function __construct()
    {
        $this->articleService = new ArticleService();
    }

    public function index()
    {
        $data = [
            'articles' => $this->articleService->getPublishedArticlesPaginated(9),
            'pager' => $this->articleService->getPager()
        ];

        return view('public/articles/index', $data);
    }

    public function show(string $slug)
    {
        $article = $this->articleService->getPublishedArticleBySlug($slug);

        if (!$article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();   
        }

        return view('public/articles/show', [
            'article' => $article,
        ]);
    }
}