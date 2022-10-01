<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfessorProfilesController extends Controller
{
    public function index()
    {
        $professors = [
            [
                'id' => 0,
                'name' => 'Lucas',
                'title' => 'Programador',
                'education' => 'Egresado de la UCV',
                'ubication' => 'Las Mercedes, Aragua',
                'skills' => 'Diseñador y programador web'
            ],
            [
                'id' => 1,
                'name' => 'Julio',
                'title' => 'Programador',
                'education' => 'Egresado de la Havana',
                'ubication' => 'Caracas',
                'skills' => 'Ingeniero DevOps'
            ],
            [
                'id' => 2,
                'name' => 'Marta',
                'title' => 'Ingeniera de ciberseguridad',
                'education' => 'Egresada de la UPTA FBF',
                'ubication' => 'La Mora, Aragua',
                'skills' => 'Diseñadora y programadora backend'
            ],
            [
                'id' => 3,
                'name' => 'Andrea',
                'title' => 'Programadora fullstack',
                'education' => 'Egresada de la UCV',
                'ubication' => 'Turmero, Aragua',
                'skills' => 'Programadora mobile'
            ],
            [
                'id' => 4,
                'name' => 'Violet',
                'title' => 'Diseñadora web',
                'education' => 'Egresada de UBA',
                'ubication' => 'Cagua, Aragua',
                'skills' => 'Profesora y programadora'
            ],
            [
                'id' => 5,
                'name' => 'Juan',
                'title' => 'Inginiero en redes',
                'education' => 'Egresado de la UC',
                'ubication' => 'Valencia',
                'skills' => 'Analista de datos'
            ],
            [
                'id' => 6,
                'name' => 'Marta',
                'title' => 'Ingeniera de software',
                'education' => 'Egresada de la UNEFA',
                'ubication' => 'El consejo, Aragua',
                'skills' => 'Diseñadora web'
            ],
        ];
        return view('profiles.index', ['professors' => $professors]);
    }
    public function show($profile)
    {
        return view('profiles.show', ['profile' => $profile]);
    }
}