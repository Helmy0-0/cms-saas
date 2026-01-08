<?php

namespace App\Services;

use App\Models\ArticleModel;
use CodeIgniter\HTTP\Exceptions\HTTPException;
use Exception;
use LogicException;

class ArticleService
{
    protected ArticleModel $articles;

    public function __construct()
    {
        $this->articles = new ArticleModel();
    }

    public function createDraft(array $data, int $authorId)
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
            throw new LogicException('This article isnt draft');
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
            throw new LogicException('This article didnt review yet');
        }

        return $this->articles->update($articleId, [
            'status' => 'published',
            'approved_by' => $approverId,
            'publish_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function reject(int $articleId, int $approverId, string $role)
    {
        if (!in_array($role, ['admin', 'editor'])) {
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

    public function takedown(int $articleId, int $userId)
    {
        $article = $this->articles->find($articleId);

        if (!$article) {
            // Debug: log untuk melihat apa yang terjadi
            log_message('error', "Takedown failed - Article ID: {$articleId} not found");
            throw new HTTPException("Article with ID {$articleId} not found in database", 404);
        }

        if ($article->author_id !== $userId) {
            log_message('error', "Takedown failed - User {$userId} is not author of article {$articleId}. Author is {$article->author_id}");
            throw new HTTPException("You are not authorized. Article belongs to author {$article->author_id}, but you are {$userId}", 403);
        }

        if ($article->status !== 'published') {
            log_message('error', "Takedown failed - Article {$articleId} status is '{$article->status}', not 'published'");
            throw new \LogicException("Only published article can be taken down. Current status: {$article->status}");
        }

        return $this->articles->update($articleId, [
            'status' => 'draft',
            'approved_by' => null,
            'publish_at' => null,
        ]);
    }

    public function getArticleById(int $articleId)
    {
        return $this->articles->find($articleId);
    }

    public function updateArticle(int $articleId, array $data, int $userId, string $role)
    {
        $article = $this->articles->find($articleId);

        if (!$article) {
            throw new Exception('Article not found', 404);
        }

        if ($role === 'writer') {
            if ($article->author_id !== $userId) {
                throw new Exception('You are not authorized', 403);
            }
            if ($article->status !== 'draft') {
                throw new LogicException('You can only edit draft articles');
            }
        }

        if (in_array($role, ['admin', 'editor'])) {
            if ($article->status === 'review') {
                $data['status'] = 'published';
                $data['approved_by'] = $userId;
                $data['publish_at'] = date('Y-m-d H:i:s');
            }
        }

        if (isset($data['title'])) {
            $data['slug'] = url_title($data['title'], '-', true);
        }

        return $this->articles->update($articleId, $data);
    }

    public function deleteArticle(int $articleId, int $userId)
    {
        $article = $this->articles->find($articleId);

        if (!$article) {
            throw new HTTPException('Article not found', 404);
        }

        if ($article->author_id !== $userId) {
            throw new HTTPException('You are not authorized', 403);
        }

        if ($article->status !== 'draft') {
            throw new LogicException('You can only delete draft articles');
        }

        return $this->articles->delete($articleId, true);
    }

    public function publish(int $articleId, int $publisherId)
    {
        $article = $this->articles->find($articleId);

        if (!$article) {
            throw new HTTPException('Article not found', 404);
        }

        return $this->articles->update($articleId, [
            'status' => 'published',
            'approved_by' => $publisherId,
            'publish_at' => date('Y-m-d H:i:s')
        ]);
    }
}