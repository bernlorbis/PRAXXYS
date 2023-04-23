<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'slug',
    'category_id',
    'description',
    'date_and_time'
  ];

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function images()
  {
    return $this->hasMany(ProductImage::class);
  }
}
