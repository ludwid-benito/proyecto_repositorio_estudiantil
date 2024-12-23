<div class="sidebar" data-color="purple" data-background-color="white">
    <div class="logo text-center py-3">
        <a href="<?php echo site_url('repositorio'); ?>" class="simple-text logo-normal">
            Repositorio
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <!-- Enlace Público -->
            <li class="nav-item <?= ($this->uri->segment(2) == 'publico') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo site_url('repositorio/publico'); ?>">
                    <i class="fas fa-globe"></i>
                    <p>Público</p>
                </a>
            </li>
            <!-- Enlace Privado -->
            <li class="nav-item <?= ($this->uri->segment(2) == 'privado') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo site_url('repositorio/privado'); ?>">
                    <i class="fas fa-lock"></i>
                    <p>Privado</p>
                </a>
            </li>
            <!-- Enlace Soporte -->
            <li class="nav-item <?= ($this->uri->segment(2) == 'soporte') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo site_url('repositorio/soporte'); ?>">
                    <i class="fas fa-headset"></i>
                    <p>Soporte</p>
                </a>
            </li>
        </ul>
    </div>
</div>
