<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Article extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'author_id' => 'integer',
        'approved_by' => 'integer',
    ];
}