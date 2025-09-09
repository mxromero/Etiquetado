<?php

namespace App\Http\Controllers;

use App\Models\ModelsImpresoras;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\User;
use App\Models\ModelsPaletizadoras;
use App\Models\ModelsProduccion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1️⃣ Traer todas las líneas activas
        $lineas = ModelsPaletizadoras::where('paletizadora', '!=', '0')
            ->where('eliminada', '!=', 'X')
            ->orderBy('paletizadora', 'asc')
            ->get();

        // 2️⃣ Hacer un conteo agrupado en la base de datos
        $producciones = ModelsProduccion::select(
                'paletizadora',
                'material',
                'NordPrev',
                \DB::raw('COUNT(*) as total')
            )
            ->whereIn('paletizadora', $lineas->pluck('paletizadora'))
            ->whereIn('NordPrev', $lineas->pluck('NordPrev'))
            ->where(function ($q) {
                $q->whereNull('exp_sap')
                ->orWhere('exp_sap', '');
            })
            ->groupBy('paletizadora', 'material', 'NordPrev')
            ->get();



        // 3️⃣ Mapear los conteos a cada línea
        foreach ($lineas as $linea) {
            $linea->exp_sap = $producciones
                ->where('paletizadora', $linea->paletizadora)
                ->where('material', $linea->material)
                ->where('NordPrev', $linea->NordPrev)
                ->pluck('total')
                ->first() ?? 0;
           $impresora = ModelsImpresoras::where('paletizadora', $linea->paletizadora)
                ->where('activa', '=', 'X')
                ->pluck('impresora')
                ->first();

            if ($impresora) {
                // Limpiar la barra y quitar IP
                $nombre = trim($impresora); // quitar espacios
                $nombre = str_replace('\\\\', '\\', $nombre); // normalizar barras

                // Obtener solo la parte después de la última barra
                $partes = explode('\\', $nombre);
                $alias = end($partes); // devuelve 'Linea1-2'

                // Agregar texto descriptivo
                $linea->impresora_alias = 'Impresora ' . $alias;

                // Mantener también la ruta completa limpia
                $linea->impresora = '\\' . ltrim($nombre, '\\');
            } else {
                $linea->impresora_alias = null;
                $linea->impresora = null;
            }
        }


        return view('home', compact('lineas'));
    }


    public function datos($paletizadora)
    {
        $linea = ModelsPaletizadoras::findOrFail($paletizadora);

        // Obtener registros de producción para esta línea
        $producciones = ModelsProduccion::where('paletizadora', $linea->paletizadora)
            ->where('exp_sap', '')
            ->get(['paletizadora', 'material', 'NordPrev']);

        // Contar cuántos registros hay
        $linea->exp_sap = $producciones->where('material', $linea->material)
            ->where('NordPrev', $linea->NordPrev)
            ->count();

        return response()->json($linea);
    }

    public function actualizarLineas()
    {
        $lineas = ModelsPaletizadoras::where('paletizadora', '!=', '0')
            ->where('eliminada', '!=', 'X')
            ->orderBy('paletizadora', 'asc')
            ->get();

        $producciones = ModelsProduccion::whereIn('paletizadora', $lineas->pluck('paletizadora'))
            ->where('exp_sap', '')
            ->get(['paletizadora', 'material', 'NordPrev']);

        foreach ($lineas as $linea) {
            $linea->exp_sap = $producciones->where('paletizadora', $linea->paletizadora)
                ->where('material', $linea->material)
                ->where('NordPrev', $linea->NordPrev)
                ->count();
            $impresora = ModelsImpresoras::where('paletizadora', $linea->paletizadora)
                ->where('activa', '=', 'X')
                ->pluck('impresora')
                ->first();

                if ($impresora) {
                    // Limpiar la barra y quitar IP
                    $nombre = trim($impresora); // quitar espacios
                    $nombre = str_replace('\\\\', '\\', $nombre); // normalizar barras

                    // Obtener solo la parte después de la última barra
                    $partes = explode('\\', $nombre);
                    $alias = end($partes); // devuelve 'Linea1-2'

                    // Agregar texto descriptivo
                    $linea->impresora_alias = 'Impresora ' . $alias;

                    // Mantener también la ruta completa limpia
                    $linea->impresora = '\\' . ltrim($nombre, '\\');
                } else {
                    $linea->impresora_alias = null;
                    $linea->impresora = null;
                }
        }

        return view('partials.lineas_cards', compact('lineas'));
    }


    function showRegistrationForm()
    {
        return view('auth.perfil');
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }


    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('perfil')->with('success', 'Contraseña actualizada correctamente.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('perfil')->with('success', 'Usuario eliminado correctamente.');
    }

}
