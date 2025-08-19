<div class="row">
    @foreach ($lineas as $linea)
        <div class="col-md-3 mb-3">
            <div class="card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modalLinea{{ $linea->paletizadora }}">
                <div style="height: 6px; background-color: {{ substr(ltrim(trim($linea->VersionF), '0'), 0, 1) === 'R' ? '#EFAF2A' : '#19A051' }}; border-top-left-radius: .3rem; border-top-right-radius: .3rem;"></div>
                <div class="card-body">
                    <h5 class="card-title">Línea {{ $linea->paletizadora }}</h5>
                    <p class="card-text">Detalles breves de la línea...</p>
                </div>
            </div>
        </div>
    <x-modal-linea :linea="$linea" />
    @endforeach
</div>
