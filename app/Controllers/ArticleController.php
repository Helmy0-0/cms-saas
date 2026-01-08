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

    public function approve($articleId)
    {
        $this->service->approve(
            (int) $articleId,
            session()->get('user_id'),
            session()->get('user_role')
        );

        return redirect()->back()->with('success', 'Article approved successfully');
    }

    public function reject($articleId)
    {
        $this->service->reject(
            (int) $articleId,
            session()->get('user_id'),
            session()->get('user_role')
        );

        return redirect()->back()->with('success', 'Article rejected successfully');
    }

    public function publish($articleId)
    {
        $this->service->publish(
            (int) $articleId,
            session()->get('user_id')
        );

        return redirect()->back()->with('success', 'Article published successfully');
    }

    public function edit($articleId)
    {
        $article = $this->service->getArticleById((int) $articleId);

        if (!$article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'article' => $article,
            'role' => session()->get('user_role'),
        ];

        return view('dashboard/edit', $data);
    }

    public function update($articleId)
    {
        $data = $this->request->getPost(['title', 'content']);

        $this->service->updateArticle(
            (int) $articleId,
            $data,
            session()->get('user_id'),
            session()->get('user_role')
        );

        $message = session()->get('user_role') === 'writer'
            ? 'Article updated successfully'
            : 'Article updated and published successfully';
        
        return redirect()->to('/dashboard')->with('success', $message);
    }

    public function delete($articleId)
    {
        $this->service->deleteArticle(
            (int) $articleId,
            session()->get('user_id')
        );

        return redirect()->to('/dashboard')->with('success', 'Article deleted successfully');
    }

    public function takedown($articleId)
    {
        $this->service->takedown(
            (int) $articleId,
            session()->get('user_id')
        );

        return redirect()->to('/dashboard')->with('success', 'Article taken down successfully');
    }
}