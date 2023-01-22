<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Academico\Pnf;
use App\Models\Academico\Trayecto;
use App\Models\User;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function __construct()
    {
        // Valida la autenticación
        $this->middleware('auth');
        $this->middleware('prevent-back-history');
    }

    public function index()
    {
        // Valida si tiene el permiso.
        permiso('perfil');

        // Busca todos los trayectos y pnf's.
        $trayectos = Trayecto::all();
        $pnfs = Pnf::all();

        return view('profile.show', compact('trayectos', 'pnfs'));
    }

    public function update(Request $request, $id)
    {
        // Valida si tiene el permiso.
        permiso('perfil');

        // Busca al usuario y le asigna el avatar seleccionado.
        $usuario = User::find($id);
        $avatar = 'avatar' . $request->avatarID;
        $usuario->avatar = $avatar;
        $usuario->save();

        return redirect()->back()->with('avatar', 'avatar');
    }
}
