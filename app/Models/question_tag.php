<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question_tag extends Model
{
    use HasFactory;

    protected $fillable = [
            'question_id',
            'tag_id'
    ];

    public $timestamps = false;

   
}
