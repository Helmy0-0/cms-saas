<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ArticleModel;
use CodeIgniter\HTTP\ResponseInterface;

class ArticleApiController extends BaseController
{
    protected ArticleModel $articles;
    public function __construct()
    {
        $this->articles = new ArticleModel();
    }

    public function index ()
    {
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 5;

        $data = $this->articles
            ->where('status', 'published')
            ->orderBy('publish_at', 'DESC')
            ->paginate($perPage);
        
        return $this->response->setJSON([
            'data' => $data,
            'meta' => [
                'current_page'  => $this->articles->pager->getCurrentPage(),
                'total_page'    => $this->articles->pager->getPageCount(),
                'total_data'    => $this->articles->pager->getTotal(), 
            ],
        ]);
    }

    public function show (string $slug)
    {
        $article = $this->articles
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();
        
        if (!$article) {
            return $this->response->setStatusCode(404)->setJSON([
                'error' => 'Article not found'
            ]);
        }

        return $this->response->setJSON([
            'data' => $article
        ]);
    }
}