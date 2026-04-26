<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //field yang ada di tabel products
    protected $fillable = ['name', 'price', 'description', 'image', 'stock', 'user_id'];

    //relasi ke user 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relasi many to many dengan category
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
}
