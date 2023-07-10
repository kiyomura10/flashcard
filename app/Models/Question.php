<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $guarded = ['id'];

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
   
    
}
