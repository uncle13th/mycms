<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';  // 明确指定表名

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'content',
        'status',
        'language',
        'image_url'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}