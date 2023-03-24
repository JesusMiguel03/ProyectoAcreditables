<?php

namespace Tests\Feature;

use App\Models\Academico\Estudiante;
use App\Models\Academico\PNF;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LoginTest extends TestCase
{
    private $usuario;

    public function setUp(): void
    {
        parent::setUp();

        $this->usuario = [
            'nombre' => 'Feature',
            'apellido' => 'Test',
            'nacionalidad' => 'P',
            'cedula' => 30999999,
            'email' => 'test@unit.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
    }

    public function testLoginPage()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Iniciar Sesión');
    }

    public function testRegisterPage()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Registrarme');
    }

    public function testIsUserRegistered()
    {
        $this->assertDatabaseHas('users', [
            'email' => 'u6@email.com',
        ]);
    }

    public function testUserIsDeleted()
    {
        $usuario = User::where('email', $this->usuario['email'])->first();

        if (!empty($usuario)) {
            $usuario->delete();

            // Realiza una consulta a la base de datos para verificar que el usuario ya no existe
            $this->assertDatabaseMissing('users', [
                'email' => 'test@unit.com',
            ]);
        } else {
            $response = $this->assertNotTrue($usuario);
        }
    }

    public function testRegisterUser()
    {
        $response = $this->get('/register')->assertStatus(200)->assertSee('Registrarme');

        $response = $this->withHeaders([
            'X-CSRF-Token' => csrf_token(),
        ])->post(
            '/register',
            [
                'nombre' => $this->usuario['nombre'],
                'apellido' => $this->usuario['apellido'],
                'nacionalidad' => $this->usuario['nacionalidad'],
                'cedula' => $this->usuario['cedula'],
                'email' => $this->usuario['email'],
                'password' => $this->usuario['password'],
                'password_confirmation' => $this->usuario['password_confirmation']
            ]
        );

        $user = User::where('email', $this->usuario['email'])->first();

        $response->assertRedirect('/');

        $this->actingAs($user);

        $this->get('/')->assertSee('Página principal');
    }

    public function testLoginUser()
    {
        $response = $this->get('/login')->assertStatus(200)->assertSee('Iniciar sesión');

        $response = $this->withHeaders([
            'X-CSRF-Token' => csrf_token(),
        ])->post(
            '/login',
            [
                'email' => $this->usuario['email'],
                'password' => $this->usuario['password'],
            ]
        );

        $user = User::where('email', $this->usuario['email'])->first();

        $response->assertRedirect('/');

        $this->actingAs($user);

        $response = $this->get('/');
        $response->assertOk();
    }

    public function testIsStudent()
    {
        // Realizar una solicitud GET a la página de inicio de sesión
        $this->get('/login')
            ->assertStatus(200)
            ->assertSee('Iniciar sesión');

        // Realizar una solicitud POST para iniciar sesión con credenciales válidas
        $this->withHeaders([
            'X-CSRF-Token' => csrf_token(),
        ])->post('/login', [
            'email' => 'u1@email.com',
            'password' => 'password',
        ])->assertRedirect('/');

        // Verificar que el usuario haya iniciado sesión correctamente
        $this->assertAuthenticated();

        // Realizar una solicitud GET a la página de perfil
        $this->get('/perfil')
            ->assertStatus(200)
            ->assertSee('Perfil académico');
    }

    public function testIsProfessor()
    {
        $this->get('/login')->assertStatus(200)->assertSee('Iniciar sesión');

        $this->withHeaders([
            'X-CSRF-Token' => csrf_token(),
        ])->post('/login', [
            'email' => 'u4@email.com',
            'password' => 'password',
        ])->assertRedirect('/');

        $this->assertAuthenticated();

        $user = User::where('email', 'u4@email.com')->first();

        $this->assertTrue($user->getRoleNames()[0] === 'Profesor');
    }
}
