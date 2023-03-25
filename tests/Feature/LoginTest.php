<?php

namespace Tests\Feature;

use App\Models\Academico\Estudiante;
use App\Models\Academico\Estudiante_materia;
use App\Models\Academico\PNF;
use App\Models\Academico\Trayecto;
use App\Models\Materia\Asistencia;
use App\Models\Materia\Materia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Faker\Factory;

class LoginTest extends TestCase
{
    public function crearUsuario()
    {
        $faker = Factory::create();

        $usuario = User::create([
            'nombre' => $faker->firstName,
            'apellido' => $faker->lastName,
            'nacionalidad' => rand(1, 2) === 1 ? 'V' : 'E',
            'cedula' => rand(80000000, 90000000),
            'email' => $faker->email,
            'password' => bcrypt('password'),
        ]);

        Estudiante::create([
            'pnf_id' => PNF::find(rand(4, 8))->id,
            'trayecto_id' => Trayecto::find(rand(1, 5))->id,
            'usuario_id' => $usuario->id,
        ]);

        return $usuario;
    }

    public function testCargarLogin()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Iniciar Sesión');
    }

    public function testCargarRegistrarme()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Registrarme');
    }

    public function testUsuarioEstaRegistrado()
    {
        $usuario = $this->crearUsuario();

        $this->assertDatabaseHas('users', [
            'email' => $usuario->email,
        ]);
    }

    public function testRegistrarUsuario()
    {
        $faker = Factory::create();

        $response = $this->get('/register')->assertStatus(200)->assertSee('Registrarme');

        $nacionalidades = ['V', 'E', 'P'];
        $correo = $faker->email;

        $response = $this->withHeaders([
            'X-CSRF-Token' => csrf_token(),
        ])->post(
            '/register',
            [
                'nombre' => $faker->firstName,
                'apellido' => $faker->lastName,
                'nacionalidad' => $nacionalidades[array_rand($nacionalidades)],
                'cedula' => rand(10000000, 99999999),
                'email' => $correo,
                'password' => 'password',
                'password_confirmation' => 'password'
            ]
        );

        $user = User::where('email', $correo)->first();

        $response->assertRedirect('/');

        $this->actingAs($user);

        $this->get('/')->assertSee('Página principal');
    }

    public function testRegistrarErroneo()
    {
        $response = $this->withHeaders([
            'X-CSRF-Token' => csrf_token(),
        ])->post(
            '/register',
            [
                'nombre' => 12156489,
                'apellido' => '#!#!"#"#',
                'nacionalidad' => 'L',
                'cedula' => rand(10000000, 9999999999),
                'email' => 'correoinvalido',
                'password' => '#$$%&$%&$%&$%&$',
                'password_confirmation' => '102'
            ]
        );

        $response->assertRedirect('/register');
    }

    public function testIniciarSesiónErronea()
    {
        $response = $this->get('/login')->assertStatus(200)->assertSee('Iniciar sesión');

        $response = $this->followingRedirects()->withHeaders([
            'X-CSRF-Token' => csrf_token(),
        ])->post(
            '/login',
            [
                'email' => 'correoinvalido',
                'password' => 'contraseñainvalida',
            ]
        );

        $response->assertSee('Iniciar sesión');
    }

    public function testIniciarSesiónConUsuario()
    {
        $response = $this->get('/login')->assertStatus(200)->assertSee('Iniciar sesión');

        $usuario = $this->crearUsuario();

        $response = $this->withHeaders([
            'X-CSRF-Token' => csrf_token(),
        ])->post(
            '/login',
            [
                'email' => $usuario->email,
                'password' => $usuario->password,
            ]
        );

        $user = User::where('email', $usuario->email)->first();

        $response->assertRedirect('/');

        $this->actingAs($user);

        $response = $this->get('/');
        $response->assertOk();
    }

    public function testUsuarioEsEstudiante()
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSee('Iniciar sesión');

        $usuario = $this->crearUsuario();

        $this->withHeaders([
            'X-CSRF-Token' => csrf_token(),
        ])->post('/login', [
            'email' => $usuario->email,
            'password' => 'password',
        ])->assertRedirect('/');

        $this->assertAuthenticated();

        $this->get('/perfil')
            ->assertStatus(200)
            ->assertSee('Perfil académico');
    }

    public function testEstudianteSeInscribe()
    {
        // Acceder a la página de inicio de sesión
        $this->get('/login')
            ->assertStatus(200)
            ->assertSee('Iniciar sesión');

        // Iniciar sesión con un usuario válido
        $usuario = $this->crearUsuario();

        $this->actingAs($usuario)
            ->withHeaders([
                'X-CSRF-Token' => csrf_token(),
            ])
            ->post('/login', [
                'email' => $usuario->email,
                'password' => 'password',
            ])
            ->assertRedirect('/');

        // Verificar que el usuario ha iniciado sesión correctamente
        $this->assertAuthenticatedAs($usuario);

        // Acceder a la página de materias y verificar que se muestra la lista de materias
        $this->get('/materias')
            ->assertStatus(200)
            ->assertSee('Ver materia');

        // Obtener una materia disponible al azar y verificar que se muestra la información de la materia
        $materia = Materia::where('cupos_disponibles', '>', 1)
            ->inRandomOrder()
            ->firstOrFail();
        $this->get("/materias/{$materia->id}")
            ->assertStatus(200)
            ->assertSee($materia->nombre);

        // Verificar que el usuario no está inscrito en la materia
        $this->get("/materias/{$materia->id}")
            ->assertStatus(200)
            ->assertSee('Inscribirme');

        // Inscribir al usuario en la materia y verificar que se muestra el mensaje de confirmación
        $this->post("/materias/{$materia->id}/inscribir")
            ->assertStatus(302)
            ->assertSessionHas('success', 'Te has inscrito en la materia correctamente.');

        // Verificar que el usuario está inscrito en la materia
        $this->get("/materias/{$materia->id}")
            ->assertStatus(200)
            ->assertSee('Se encuentra inscrito en esta acreditable.');
    }
    // {
    //     $this->get('/login')
    //         ->assertStatus(200)
    //         ->assertSee('Iniciar sesión');

    //     $this->withHeaders([
    //         'X-CSRF-Token' => csrf_token(),
    //     ])->post('/login', [
    //         'email' => 'u1@email.com',
    //         'password' => 'password',
    //     ])->assertRedirect('/');

    //     $this->assertAuthenticated();

    //     $this->get('/materias')
    //         ->assertStatus(200)
    //         ->assertSee('Ver materia');

    //     $usuario = User::where('email', 'u1@email.com')->first();
    //     $materia = Materia::where('trayecto_id', '=', $usuario->estudiante->trayecto->id)->where('cupos_disponibles', '>', 1)->get()->random()->id;

    //     $response = $this->get("/materias/{$materia}")->assertStatus(200);

    //     if ($response->assertSee('Inscribirme')) {
    //         $response = $this->get("/materias/{$materia}/inscribir");
    //         $response->assertStatus(200);
    //         $this->get("/materias/{$materia}")->assertStatus(200)->assertSee('Se encuentra inscrito en esta acreditable.');
    //     } else {
    //         $response->assertSee('Se encuentra inscrito en esta acreditable.');
    //     }
    // }

    public function testEstudiantePuedeInscrirMateria()
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSee('Iniciar sesión');

        $usuario = $this->crearUsuario();

        $this->withHeaders([
            'X-CSRF-Token' => csrf_token(),
        ])->post('/login', [
            'email' => $usuario->email,
            'password' => 'password',
        ])->assertRedirect('/');

        $this->assertAuthenticated();

        $this->get('/materias')
            ->assertStatus(200)
            ->assertSee('Ver materia');

        $usuario = User::where('email', $usuario->email)->first();
        $materia = Materia::where('trayecto_id', '=', $usuario->estudiante->trayecto->id)->where('cupos_disponibles', '>', 1)->get()->random()->id;

        $this->get("/materias/{$materia}")->assertStatus(200)->assertSee('Inscribirme');
    }

    public function testEstudianteEsRedirigidoSiBuscaMateriaQueNoCoincideConSuTrayecto()
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSee('Iniciar sesión');

        $usuario = $this->crearUsuario();

        $this->withHeaders([
            'X-CSRF-Token' => csrf_token(),
        ])->post('/login', [
            'email' => $usuario->email,
            'password' => 'password',
        ])->assertRedirect('/');

        $this->assertAuthenticated();

        $this->get('/materias')
            ->assertStatus(200)
            ->assertSee('Ver materia');

        $usuario = User::where('email', $usuario->email)->first();
        $materia = Materia::where('trayecto_id', '=', $usuario->estudiante->trayecto->id + 1)->where('cupos_disponibles', '>', 1)->get()->random()->id;

        $response = $this->get("/materias/{$materia}")->assertStatus(302);
        $response->assertRedirect('/materias');
        $response = $this->get('/materias')->assertStatus(200);
        $response->assertSee('Materias');
    }

    // public function testRedireccionaSiEstudianteIntentaAccederAlComprobanteDeOtro()
    // {
    //     $this->get('/login')
    //         ->assertStatus(200)
    //         ->assertSee('Iniciar sesión');

    //     $usuario = $this->crearUsuario();

    //     $response = $this->followingRedirects()->withHeaders([
    //         'X-CSRF-Token' => csrf_token(),
    //     ])->post('/login', [
    //         'email' => $usuario->email,
    //         'password' => 'password',
    //     ]);

    //     $this->assertAuthenticated();

    //     $response->assertSee('Página principal');
    //     // $this->get('/estudiante/1/comprobante/1')->assertStatus(302);
    // }
}
