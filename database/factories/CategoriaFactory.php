<?php

namespace Database\Factories;

use App\Models\Materia\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom_categoria' => $this->faker->shuffle('Categoria'),
        ];
    }
}
