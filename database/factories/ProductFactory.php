<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    $productName = fake()->name();

    return [
      'name' => $productName,
      'slug' => Str::slug($productName),
      'category_id' => rand(1, 5),
      'description' => fake()->sentence(),
      'date_and_time' => date('Y-m-d H:i')
    ];
  }
}
