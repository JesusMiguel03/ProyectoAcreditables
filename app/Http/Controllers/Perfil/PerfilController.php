<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Academico\Periodo;
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
        // Valida si tiene el permiso
        permiso('perfil');

        $trayectos = Trayecto::all();
        $pnfs = Pnf::all();

        return view('profile.show', compact('trayectos', 'pnfs', ['periodo' => periodoActual()]));
    }

    public function update(Request $request)
    {
        // Valida si tiene el permiso
        permiso('perfil');

        $usuario = User::find($request->usuarioID);
        $avatar = 'avatar' . $request->avatarID;
        $usuario->avatar = $avatar;
        $usuario->save();

        return redirect()->back()->with('avatar', 'avatar');
    }
}
