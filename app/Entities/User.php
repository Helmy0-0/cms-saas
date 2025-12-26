<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $casts = [
        'id' => 'integer',
    ];

    protected $hidden = ['password'];
}