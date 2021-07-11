<?php

namespace Database\Factories\Promotion;

use App\Models\Category\Category;
use App\Models\Promotion\Promotion;
use App\Models\Promotion\PromotionType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Promotion::class;

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
            'status' => true,
            'type_id' => PromotionType::all()->random(1)->first()->id,
        ];
    }
}
