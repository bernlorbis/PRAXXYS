<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    if (request()->wantsJson()) {
      return Product::query()
        ->with(['category', 'images'])
        ->when(request()->q || request()->category, function ($query) {
          $query->where(function ($query) {
            $query->where('description', 'like', '%' . request()->q . '%')
              ->orWhereHas('category', function ($query) {
                $query->where('name', 'like', '%' . request()->q . '%');
              });
          })
            ->when(request()->category, function ($query) {
              $query->where('category_id', request()->category);
            });
        })
        ->when(request()->sortBy && request()->sortType, function ($query) {
          $query->when(request()->sortBy == 'category', function ($query) {
            $query->orderBy(Category::select('name')->whereColumn('categories.id', 'products.category_id'), request()->sortType);
          });

          $query->when(request()->sortBy !== 'category', function ($query) {
            $query->orderBy(request()->sortBy, request()->sortType);
          });
        })
        ->orderBy('id', 'desc')
        ->paginate(request()->rowsPerPage)
        ->through(fn ($product) => [
          'id' => $product->id,
          'images' => $product->images,
          'name'  => $product->name,
          'category' => $product->category->name,
          'description' => $product->description
        ]);
    }

    return Inertia::render('Products/Index', array(
      'categories' => Category::pluck('name', 'id')
    ));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return Inertia::render('Products/Create/Show', array(
      'categories' => Category::pluck('name', 'id')
    ));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreProductRequest $request)
  {
    $product = Product::create($request->validated() + ['slug' => Str::slug($request->name)]);

    foreach ($request->file('files') as $file) {
      $imagePath = $file->store('img/products', 'public');

      $product->images()->create(array(
        'path' => $imagePath
      ));
    }

    return redirect()->route('products.index');
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Product $product)
  {
    return Inertia::render('Products/Edit/Show', array(
      'categories' => Category::pluck('name', 'id'),
      'product' => $product->load('images'),
    ));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Product $product)
  {
    switch ($request->step) {
      case 1:
        $params = $this->validate($request, array(
          'name' => 'required|unique:products,name,' . $product->id,
          'category_id' => 'required',
          'description' => 'required'
        ));

        $product->fill($params);

        if ($product->isDirty()) $product->save();
        break;
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Product $product)
  {
    foreach ($product->images as $image) {
      if ($image->path && Storage::exists("/public/{$image->path}")) {
        Storage::delete("/public/{$image->path}");
      }

      $image->delete();
    }

    $product->delete();

    return redirect()->route('products.index');
  }

  public function isProductNameAvailable(Request $request)
  {
    if (isset($request->id)) {
      return Product::query()
        ->where('slug', Str::slug($request->name))
        ->whereNot('id', '=', $request->id)
        ->count() == 0;
    }

    return Product::where('slug', Str::slug($request->name))->count() == 0;
  }
}
