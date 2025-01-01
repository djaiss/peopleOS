<?php

namespace Database\Factories;

use App\Models\Day;
use App\Models\Journal;
use App\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Day>
 */
class DayFactory extends Factory
{
    protected $model = Day::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'journal_id' => Journal::factory(),
            'template_id' => Template::factory(),
            'date' => $this->faker->date(),
        ];
    }
}
