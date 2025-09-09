@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 100%;">
    <div class="row">
        <div class="col-md-12">
            <h2>Modificación Masiva de Producción</h2>

            {{-- FILTROS --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Filtros de búsqueda</h5>
                    <div class="row">
                        <!-- Mes -->
                        <div class="col-md-3">
                            <label for="mes" class="form-label">Mes</label>
                            <input type="month" id="mes" name="mes"
                                   value="{{ now()->format('Y-m') }}"
                                   class="form-control">
                        </div>

                        <!-- Material -->
                        <div class="col-md-4">
                            <label for="material" class="form-label">Material</label>
                            <select id="material" name="material" class="form-control">
                                <option value="">-- Seleccione --</option>
                                @foreach($materiales as $m)
                                    <option value="{{ $m['material'] }}">{{ $m['material'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Orden Previsional -->
                        <div class="col-md-3">
                            <label for="orden_previsional" class="form-label">Orden Previsional</label>
                            <input type="text" id="orden_previsional" name="orden_previsional" class="form-control" placeholder="Ingrese la orden previsional">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button id="btnBuscar" class="btn btn-primary w-100">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RESULTADOS --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5>Resultados</h5>
                    <div id="resultado" class="table-responsive">
                        <p class="text-muted">Seleccione filtros y presione "Buscar".</p>
                        {{-- Aquí se cargará la tabla con AJAX --}}
                    </div>
                </div>
            </div>

            {{-- MODIFICACIÓN MASIVA --}}
            <div class="card">
                <div class="card-body">
                    <h5>Aplicar cambio masivo</h5>
                    <form id="formMasivo" method="POST" action="">
                        @csrf
                        <!-- Campos ocultos para reenviar filtros -->
                        <input type="hidden" name="mes" id="mesSeleccionado">
                        <input type="hidden" name="material" id="materialSeleccionado">
                        <input type="hidden" name="orden_previsional" id="ordenSeleccionado">

                        {{-- Campos frecuentes --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="NOrdPrev" class="form-label">Nueva Orden Previsional</label>
                                <input type="text" id="NOrdPrev" name="campos[NOrdPrev]" class="form-control" placeholder="Ej: 80325">
                            </div>
                            <div class="col-md-6">
                                <label for="VersionF" class="form-label">Nueva Versión Fabric.</label>
                                <input type="text" id="VersionF" name="campos[VersionF]" class="form-control" placeholder="Ej: 2012">
                            </div>
                        </div>

                        {{-- Otros campos --}}
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="fecha" class="form-label">Nueva fecha</label>
                                <input type="date" id="fecha" name="campos[fecha]" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="hora" class="form-label">Nueva hora</label>
                                <input type="time" id="hora" name="campos[hora]" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cantidad" class="form-label">Nueva cantidad</label>
                                <input type="number" step="1" id="cantidad" name="campos[cantidad]" class="form-control" placeholder="Ej: 45">
                            </div>
                            <div class="col-md-6">
                                <label for="fechaCodificado" class="form-label">Nueva Fecha Codificado</label>
                                <input type="date" id="fechaCodificado" name="campos[fechaCodificado]" class="form-control">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger">Actualizar en Masa</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Script JS --}}
@push('scripts')
<script>
document.getElementById('btnBuscar').addEventListener('click', function () {
    let mes = document.getElementById('mes').value;
    let material = document.getElementById('material').value;
    let orden = document.getElementById('orden_previsional').value;

    if(!mes || !material || !orden){
        alert("Debe seleccionar Mes, Material y Orden Previsional");
        return;
    }

    // Guardamos los filtros para el form de actualización masiva
    document.getElementById('mesSeleccionado').value = mes;
    document.getElementById('materialSeleccionado').value = material;
    document.getElementById('ordenSeleccionado').value = orden;

    // Llamada AJAX al backend

    fetch(`/buscar-registros/${mes}/${material}/${orden}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('resultado').innerHTML = html;
        });
});

// ------------------- PAGINACIÓN AJAX -------------------
document.addEventListener('click', function(e){
    // Intercepta clicks sobre links dentro de .pagination
    if(e.target.closest('.pagination a')){
        e.preventDefault();
        let url = e.target.closest('a').getAttribute('href');

        fetch(url)
            .then(res => res.text())
            .then(html => {
                document.getElementById('resultado').innerHTML = html;
            });
    }
});
</script>
@endpush
@endsection
