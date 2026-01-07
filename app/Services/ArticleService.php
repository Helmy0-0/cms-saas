<?php

namespace App\Services;

use App\Models\ArticleModel;
use CodeIgniter\HTTP\Exceptions\HTTPException;

class ArticleService
{
    protected ArticleModel $articles;

    public function __construct()
    {
        $this->articles = new ArticleModel();
    }

    public function createDraft (array $data, int $authorId)
    {
        $data['status'] = 'draft';
        $data['author_id'] = $authorId;
        $data['slug'] = url_title($data['title'], '-', true);

        return $this->articles->insert($data);
    }

    public function submitForReview(int $articleId, int $userId)
    {
        $article = $this->articles->find($articleId);

        if (!$article || $article->author_id !== $userId) {
            throw new HTTPException('You cant submit this article', 403);
        }

        if ($article->status !== 'draft') {
            throw new \LogicException('This article isnt draft');
        }

        return $this->articles->update($articleId, [
            'status' => 'review',
        ]);
    }

    public function approve(int $articleId, int $approverId, string $role)
    {
        if (!in_array($role, ['admin', 'editor'])) {
            throw new HTTPException('Your role cant approve this article', 403);
        }

        $article = $this->articles->find($articleId);

        if (!$article) {
            throw new HTTPException('/Article not found', 404);
        }

        if ($article->status !== 'review') {
            throw new \LogicException('This article didnt review yet');
        }

        return $this->articles->update($articleId, [
            'status' => 'published',
            'approved_by' => $approverId,
            'publish_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function reject(int $articleId, int $approverId, string $role)
    {
        if(!in_array($role, ['admin', 'editor'])){
            throw new HTTPException('Your role cant reject this article', 403);
        }

        $article = $this->articles->find($articleId);

        if (!$article) {
            throw new HTTPException('Article not found', 404);
        }

        return $this->articles->update($articleId, [
            'status' => 'draft'
        ]);
    }

    public function getPublishedArticlesPaginated(int $perPage)
    {
        return $this->articles
            ->select('articles.*, users.name as author_name')
            ->join('users', 'users.id = articles.author_id', 'left')
            ->where('articles.status', 'published')
            ->orderBy('articles.publish_at', 'DESC')
            ->paginate($perPage);
    }

    public function getPublishedArticleBySlug(string $slug)
    {
        return $this->articles
            ->select('articles.*, users.name as author_name')
            ->join('users', 'users.id = articles.author_id', 'left')
            ->where('articles.slug', $slug)
            ->where('articles.status', 'published')
            ->first();
    }

    public function getPager()
    {
        return $this->articles->pager;
    }

    public function getAllArticles()
    {
        return $this->articles
            ->select('articles.*, users.name as author_name')
            ->join('users', 'users.id = articles.author_id', 'left')
            ->orderBy('articles.created_at', 'DESC')
            ->findAll();
    }

    public function getArticlesByAuthor(int $authorId)
    {
        return $this->articles
            ->select('articles.*, users.name as author_name')
            ->join('users', 'users.id = articles.author_id', 'left')
            ->where('articles.author_id', $authorId)
            ->orderBy('articles.created_at', 'DESC')
            ->findAll();
    }
}