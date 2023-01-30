<?php

namespace Database\Factories;

use App\Models\Academico\AreaConocimiento;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaConocimientoFactory extends Factory
{
    protected $model = AreaConocimiento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom_conocimiento' => $this->faker->text(4),
            'desc_conocimiento' => $this->faker->text(200),
        ];
    }
}
