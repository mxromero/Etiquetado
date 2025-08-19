<!-- resources/views/Configuracion/editar.blade.php -->

<form action="{{ route('configuracion.update', $configuracion->paletizadora) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Row 1 -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="paletizadora" class="form-label">Línea</label>
            <input type="text" class="form-control" id="paletizadora" name="paletizadora"
                   value="{{ $configuracion->paletizadora }}" readonly>
        </div>

        <div class="col-md-4 mb-3">
            <label for="NOrdPrev" class="form-label">Orden Prev</label>
            <input type="text" class="form-control" id="NOrdPrev_{{ $configuracion->paletizadora  }}" name="NOrdPrev"
                   value="{{ $configuracion->NOrdPrev ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label for="fecha" class="form-label">Fecha Producción</label>
            <input type="date" class="form-control" id="fecha_{{ $configuracion->paletizadora  }}" name="fecha"
                   value="{{ $configuracion->fecha ? date('Y-m-d', strtotime($configuracion->fecha)) : '' }}">
        </div>
    </div>

    <!-- Divider -->
    <div class="divider-container">
        <div class="divider-line"></div>
    </div>

    <!-- Row 2 -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="VersionF" class="form-label">Ver.Fab</label>
            <input type="text" class="form-control" id="VersionF_{{ $configuracion->paletizadora  }}" name="VersionF"
                   value="{{ $configuracion->VersionF ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label for="centro" class="form-label">Centro</label>
            <input type="text" class="form-control" id="centro_{{ $configuracion->paletizadora  }}" name="centro"
                   value="{{ $configuracion->centro ?? '' }}" disabled>
        </div>

        <div class="col-md-4 mb-3">
            <label for="almacen" class="form-label">Almacén</label>
            <input type="text" class="form-control" id="almacen_{{ $configuracion->paletizadora  }}" name="almacen"
                   value="{{ $configuracion->almacen ?? '' }}">
        </div>
    </div>

    <!-- Divider -->
    <div class="divider-container">
        <div class="divider-line"></div>
    </div>

    <!-- Row 3 -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="material_orden" class="form-label">Material Orden</label>
            <input type="text" class="form-control" id="material_orden_{{ $configuracion->paletizadora  }}" name="material_orden"
                   value="{{ $configuracion->material_orden ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label for="pedido" class="form-label">Pedido</label>
            <input type="text" class="form-control" id="pedido_{{ $configuracion->paletizadora  }}" name="pedido"
                   value="{{ ltrim($configuracion->pedido, '0') ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label for="pos" class="form-label">Posición</label>
            <input type="text" class="form-control" id="pos_{{ $configuracion->paletizadora  }}" name="pos"
                   value="{{ ltrim($configuracion->pos, '0') ?? '' }}">
        </div>
    </div>

    <!-- Divider -->
    <div class="divider-container">
        <div class="divider-line"></div>
    </div>

    <!-- Row 4 -->
    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="lote_vac" class="form-label">Lote Vac</label>
            <input type="text" class="form-control" id="lote_vac_{{ $configuracion->paletizadora  }}" name="lote_vac"
                   value="{{ $configuracion->lote_vac ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label for="ltxcj" class="form-label">LT x CJ</label>
            <input type="text" class="form-control" id="ltxcj_{{ $configuracion->paletizadora  }}" name="ltxcj"
                   value="{{ $configuracion->ltxcj ?? '' }}">
        </div>

        <div class="col-md-4 mb-3">
            <label for="um" class="form-label">UM</label>
            <input type="text" class="form-control" id="um_{{ $configuracion->paletizadora  }}" name="um"
                   value="{{ $configuracion->um ?? '' }}">
        </div>
    </div>

    <!-- Divider -->
    <div class="divider-container">
        <div class="divider-line"></div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-3">
        <button type="submit" name="grabar" id="saveChanges" class="btn btn-primary" >
            <i class="fas fa-save me-2"></i> Guardar Cambios
        </button>
        <button type="button" name="btnLimpiar" id="botonLimpiar" class="btn btn-secondary" onclick="limipiar({{ $configuracion->paletizadora }})">
            <i class="fa fa-undo"></i> Limpiar
        </button>
        <button type="button" name="btnSAP" id="botonSAP" class="btn btn-secondary" onclick="consulta_op_sap({{ $configuracion->paletizadora }})">
            <i class="fa fa-cloud-download me-2"></i> Importar SAP
        </button>
    </div>
</form>

<style>
    .form-control {
        padding: 2px 5px;
        height: auto;
        font-size: 0.9rem;
    }
    .form-label {
        font-weight: bold;
    }
    .divider-container {
        width: 100%;
        padding: 0 15px;
        margin-bottom: 1rem;
    }
    .divider-line {
        height: 1px;
        background-color: #333338;
        width: 100%;
        display: block;
    }
</style>

