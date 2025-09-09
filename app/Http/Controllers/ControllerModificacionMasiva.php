<?php

namespace App\Http\Controllers;

use App\Models\LogModificacion;
use App\Models\ModelsProduccion;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ControllerModificacionMasiva extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inicio = Carbon::now()->submonth()->startOfMonth();
        $fin    = Carbon::now()->endOfMonth();

        $materiales = ModelsProduccion::select('material')
            ->whereBetween('fecha', [$inicio, $fin])
            ->distinct()
            ->get();

        return view('reportes.modificacion-masiva', compact('materiales'));
    }

    public function buscarRegistros($mes, $material, $orden)
    {
        $ordenPrevisional = str_pad($orden, 10, '0', STR_PAD_LEFT);
        $registros = ModelsProduccion::whereYear('fecha', substr($mes, 0, 4))
            ->whereMonth('fecha', substr($mes, 5, 2))
            ->where('material', $material)
            ->where('NOrdPrev', $ordenPrevisional)
            ->orderBy('fecha', 'asc')
            ->paginate(10);


        return view('partials.registros', compact('registros'));
    }

    public function updateMasivo(Request $request)
    {
        $validated = $request->validate([
            'mes' => 'required',
            'material' => 'required',
            'NOrdPrev' => 'required',
        ]);

        // Armamos solo los campos que tengan valor
        $data = [];
        if ($request->filled('VersionF')) {
            $data['VersionF'] = $request->VersionF;
        }
        if ($request->filled('NOrdPrev')) {
            $data['NOrdPrev'] = $request->NOrdPrev;
        }
        if ($request->filled('fecha')) {
            $data['fecha'] = $request->fecha;
        }
        if($request->filled('hora')){
            $data['hora'] = $request->hora;
        }
        if($request->filled('cantidad')){
            $data['cantidad'] = $request->cantidad;
        }
        if($request->filled('fechaCodificado')){
            $data['fechaCodificado'] = $request->fechaCodificado;
        }

        if (empty($data)) {
            return back()->with('warning', 'No seleccionó ningún campo para modificar.');
        }

            // Obtener registros afectados antes de la actualización
        $registros = ModelsProduccion::whereYear('fecha', substr($request->mes, 0, 4))
            ->whereMonth('fecha', substr($request->mes, 5, 2))
            ->where('material', $request->material)
            ->where('orden_previsional', $request->orden_previsional)
            ->get();

            foreach ($registros as $registro) {
            LogModificacion::create([
                'usuario' => Auth::user()->name, // o Auth::id() si prefieres el id
                'material' => $registro->material,
                'orden_previsional' => $registro->orden_previsional,
                'fecha' => $registro->fecha,
                'campos_anteriores' => json_encode($registro->only(array_keys($data))),
                'campos_nuevos' => json_encode($data),
            ]);
        }


        ModelsProduccion::whereYear('fecha', substr($request->mes, 0, 4))
            ->whereMonth('fecha', substr($request->mes, 5, 2))
            ->where('material', $request->material)
            ->where('orden_previsional', $request->orden_previsional)
            ->update($data);

        return back()->with('success', 'Registros actualizados masivamente.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
