<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notice;

class NoticeFactory extends Factory
{

    protected $model = Notice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => '1',
            'funded_id' => '1',
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
        ];
    }
}
