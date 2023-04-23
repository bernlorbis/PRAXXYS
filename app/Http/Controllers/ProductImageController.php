<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $product = Product::find($request->product);

    foreach ($request->file('files') as $file) {
      $imagePath = $file->store('img/products', 'public');

      $product->images()->create(array(
        'path' => $imagePath
      ));
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ProductImage $productImage): void
  {
    if ($productImage->path && Storage::exists("/public/{$productImage->path}")) {
      Storage::delete("/public/{$productImage->path}");

      $productImage->delete();
    }
  }
}
