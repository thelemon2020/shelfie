<?php

namespace Database\Factories;

use App\Models\Release;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReleaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Release::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'artist' => $this->faker->firstName,
            'title' => $this->faker->word,
            'genre_id' => $this->faker->uuid,
            'release_year' => $this->faker->year,
            'thumbnail' => 'https://placehold.it/50x50',
        ];
    }
}
