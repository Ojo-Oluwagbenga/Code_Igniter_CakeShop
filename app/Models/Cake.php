<?php

namespace App\Models;

use CodeIgniter\Model;

class Cake extends Model{
    protected $table            = 'cakes';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name', 'maker', 'type', 'recipe', 'price', 'apikey'];
}
