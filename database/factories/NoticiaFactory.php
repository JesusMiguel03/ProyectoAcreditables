<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NoticiaFactory extends Factory
{
    protected $model = \App\Models\Informacion\Noticia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->text(10),
            'desc_noticia' => $this->faker->text(60),
            'activo' => 1
        ];
    }
}
