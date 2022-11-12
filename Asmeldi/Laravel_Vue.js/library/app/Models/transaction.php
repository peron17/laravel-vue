<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';

    public function members()
    {
        return $this->hasMany('App\Models\Members', 'member_id');
    }
}
