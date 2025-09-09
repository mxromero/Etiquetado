@if($registros->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Unidad Manipulación</th>
                    <th>Fecha</th>
                    <th>Fecha Codificado</th>
                    <th>Hora</th>
                    <th>Material</th>
                    <th>Lote</th>
                    <th>Orden Previsional</th>
                    <th>Versión Fabricación</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registros as $r)
                    <tr>
                        <td>{{ ltrim($r->uma,'0') }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $r->fechaCodificado ? \Carbon\Carbon::parse($r->fechaCodificado)->format('d/m/Y') : '' }}</td>
                        <td>{{ $r->hora }}</td>
                        <td>{{ $r->material }}</td>
                        <td>{{ $r->lote }}</td>
                        <td>{{ $r->NOrdPrev }}</td>
                        <td>{{ $r->VersionF }}</td>
                        <td>{{ $r->cantidad }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Links de paginación centrados y mensaje oculto --}}
    <div class="d-flex justify-content-center">
        <style>
            /* Oculta el mensaje "Showing X to Y of Z results" de Bootstrap 5 */
            .pagination .d-flex.w-100.text-muted.mt-2 {
                display: none;
            }

            /* Opcional: mejorar el espaciado de la tabla */
            table.table-bordered th, table.table-bordered td {
                vertical-align: middle;
                text-align: center;
            }

            /* Opcional: filas hover */
            table.table-hover tbody tr:hover {
                background-color: #f1f1f1;
            }
        </style>

        {{ $registros->links('pagination::bootstrap-5') }}
    </div>
@else
    <p class="text-muted">No se encontraron registros.</p>
@endif
