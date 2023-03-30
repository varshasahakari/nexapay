<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $attributes = [
        'id'         => null,
        'name'       => null, // In the $attributes, the key is the db column name
        'password'   => null,
        'created_at' => null,
        'updated_at' => null,
    ];
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];
}
