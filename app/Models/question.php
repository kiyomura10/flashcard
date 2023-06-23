<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $guarded = ['id'];

    public function tags(){
        return $this->belongsToMany(tag::class,'question_tags');
    }
   
}
