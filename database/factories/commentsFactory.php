<?php

namespace Database\Factories;

use App\Models\comments;
use Illuminate\Database\Eloquent\Factories\Factory;

class commentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = comments::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->text,
            'created_at'=>$this->faker->dateTimeBetween('-3 months'),
        ];
    }
}
