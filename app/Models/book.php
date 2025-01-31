<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author', 'description', 'status'];

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
