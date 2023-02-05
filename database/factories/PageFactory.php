<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use App\Models\Page;

use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{

    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     *
     */
    protected $fillable = ['category_id', 'title', 'image', 'description'];

    public function definition()
    {
        return [
            'category_id' => '1',
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
        ];
    }
}
