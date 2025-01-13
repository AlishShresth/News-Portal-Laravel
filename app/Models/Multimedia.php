<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'path', 'alt_text', 'caption', 'article_id'];

    public function article(){
        return $this->belongsTo(Article::class);
    }
}
