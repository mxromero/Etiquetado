<style>
/* Estilo general de los enlaces del menú */
.accordion-body a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 15px;
    text-decoration: none;
    color: #333;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.2s ease-in-out;
    margin: 4px 6px;
}

/* Efecto hover */
.accordion-body a:hover {
    background-color: #f0f4ff;
    color: #0d6efd;
    transform: translateX(4px);
}
</style>

<div class="accordion" id="menuAccordion">

    <!-- Inicio (siempre abierto, sin toggle) -->
    <div class="accordion-item border-0">
        <h2 class="accordion-header">
            <button class="accordion-button bg-primary text-white" type="button" disabled>
                🏠 Inicio
            </button>
        </h2>
        <div class="accordion-collapse collapse show">
            <div class="accordion-body p-0">
                <a href="/home">🏠 Inicio</a>
                <a href="/perfil">👤 Perfil</a>
            </div>
        </div>
    </div>

    <!-- Producción -->
    <div class="accordion-item border-0">
        <h2 class="accordion-header" id="headingProduccion">
            <button class="accordion-button bg-warning text-dark show" type="button"  aria-expanded="false" aria-controls="collapseProduccion">
                ⚙️ Producción
            </button>
        </h2>
        <div id="collapseProduccion" class="accordion-collapse collapse show" data-bs-parent="#menuAccordion">
            <div class="accordion-body p-0">
                <a href="/impresoras">🖨️ Impresoras</a>
                <a href="/configuracion">📥 Cargar Orden Previsional</a>
                <a href="/vaciados">📦 Vaciado a Línea</a>
                <a href="/notificaciones">🔔 Notificación Producción</a>
                <a href="/fuera-norma">⚠️ Fuera Norma</a>
            </div>
        </div>
    </div>

    <!-- Reportes -->
    <div class="accordion-item border-0">
        <h2 class="accordion-header" id="headingReportes">
            <button class="accordion-button collapsed bg-info text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseReportes" aria-expanded="false" aria-controls="collapseReportes">
                📊 Reportes
            </button>
        </h2>
        <div id="collapseReportes" class="accordion-collapse collapse show" data-bs-parent="#menuAccordion">
            <div class="accordion-body p-0">
                <a href="/trazabilidad">🔍 Reporte Consumo</a>
                <a href="/reporteDia">📅 Reporte Diario</a>
                <a href="{{ route('reportes.vaciado_produccion') }}">🏭 Reporte Prod. Vaciado</a>
                <p><a href="#" class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">♻️ Recuperación Umas</a></p>
            </div>
        </div>
    </div>

    <!-- Configuración -->
    <div class="accordion-item border-0">
        <h2 class="accordion-header" id="headingConfig">
            <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseConfig" aria-expanded="false" aria-controls="collapseConfig">
                ⚙️ Configuración
            </button>
        </h2>
        <div id="collapseConfig" class="accordion-collapse collapse show" data-bs-parent="#menuAccordion">
            <div class="accordion-body p-0">
                <a href="/configuracion/usuarios">👥 Usuarios</a>
                <a href="/configuracion/rol">🔑 Roles</a>
                <a href="/configuracion/permisos">🛡️ Permisos</a>
                <a href="/configuracion/lineas">➕ Agregar Nuevas Líneas</a>
            </div>
        </div>
    </div>

    <!-- Logout -->
    <div class="accordion-item border-0">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed bg-danger text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapseLogout" aria-expanded="false" aria-controls="collapseLogout">
                🚪 Salir
            </button>
        </h2>
        <div id="collapseLogout" class="accordion-collapse collapse show">
            <div class="accordion-body p-0">
                <a href="{{ route('logout') }}" class="text-danger fw-bold"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    🔓 Cerrar Sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para permitir cerrar con clic nuevamente -->
<script>
document.querySelectorAll('.accordion-button').forEach(button => {
    button.addEventListener('click', function () {
        const target = document.querySelector(this.dataset.bsTarget);
        if (target && target.classList.contains('show')) {
            target.classList.remove('show');
            this.classList.add('collapsed');
            this.setAttribute('aria-expanded', 'false');
        }
    });
});
</script>
