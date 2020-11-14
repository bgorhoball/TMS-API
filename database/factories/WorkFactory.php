<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Work::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = User::FIELD_ID;
        return [
            Work::FIELD_ID_USER => User::all()->random()->$user_id,
            Work::FIELD_DETAILS => $this->faker->sentence,
            Work::FIELD_DATE    => $this->faker->dateTimeThisDecade,
            Work::FIELD_HOURS   => $this->faker->numberBetween(0, 24),
            Work::FIELD_EST_HOURS   => $this->faker->numberBetween(0, 24),
        ];
    }
}
