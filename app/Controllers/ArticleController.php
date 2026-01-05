<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\ArticleService;

class ArticleController extends BaseController
{
    protected ArticleService $service;

    public function __construct()
    {
        $this->service = new ArticleService();
    }

    public function store()
    {
        $data = $this->request->getPost(['title', 'content']);

        $this->service->createDraft($data, session()->get('user_id'));

        return redirect()->to('/articles');
    }

    public function submit($id) 
    {
        $this->service->submitForReview($id, session()->get('user_id'));

        return redirect()->back();
    }

    public function approve(int $articleId)
    {
        $this->service->approve(
            $articleId,
            session()->get('user_id'),
            session()->get('user_role')
        );

        return redirect()->back()->with('success', 'Article approved successfully');
    }

    public function reject(int $articleId)
    {
        $this->service->reject(
            $articleId,
            session()->get('user_id'),
            session()->get('user_role')
        );

        return redirect()->back()->with('success', 'Article rejected successfully');
    }
}