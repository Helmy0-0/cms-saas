<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\Article;

class ArticleModel extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';

    protected $returnType = Article::class;

    protected $allowedFields = [
        'title',
        'slug',
        'content',
        'status',
        'author_id',
        'approved_by',
        'publish_at'
    ];

    protected $useTimestamps = true;
    // protected $useSoftDeletes = true;
}