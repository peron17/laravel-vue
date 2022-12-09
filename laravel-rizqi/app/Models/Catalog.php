<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function books()
    {
        return $this->hasMany(Book::class, 'catalog_id', 'id');
    }
}