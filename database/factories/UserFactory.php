<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id = 1;

        $correo = 'u' . $id++ . '@test.com';

        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'nacionalidad' => rand(1, 2) === 1 ? 'V' : 'E',
            'cedula' => rand(80000000, 90000000),
            'email' => $correo,
            'password' => bcrypt('password'),
        ];
    }
}
