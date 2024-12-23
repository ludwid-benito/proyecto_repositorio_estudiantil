<div class="container mt-4">
    <h1>Panel de Administración</h1>
    <p>Bienvenido, <?= $this->session->userdata('username'); ?>.</p>

    <ul>
        <li><a href="<?= site_url('repositorio/ver_mensajes'); ?>">Ver Mensajes de Soporte</a></li>
        <li><a href="<?= site_url('repositorio/gestionar_usuarios'); ?>">Gestionar Usuarios</a></li>
        <!-- Agrega más opciones según sea necesario -->
    </ul>
</div>
