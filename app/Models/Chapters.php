<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapters extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'title',
        'audio',
        'content',
        'created_by',
        'updated_by',
    ];
}
