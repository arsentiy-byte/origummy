<?php

namespace Database\Factories\Product;

use App\Models\Category\Category;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->text(20),
            'price' => $this->faker->randomNumber(),
            'old_price' => $this->faker->randomNumber(),
            'count' => $this->faker->randomNumber(),
            'category_id' => Category::all()->random(1)->first()->id,
        ];
    }
}
