<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class FoodsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'count' => $this->faker->numberBetween(1, 100),
            'category_id' => Category::factory(),
            'image_path' => $this->faker->image('public/images', 640, 480, null, false)
        ];
    }
}
