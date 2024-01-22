<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ isset($activePage) && $activePage === 'dashboard' ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>
<li class="nav-header">Configurações</li>
<li class="nav-item">
    <a href="{{ route('devices.index') }}" class="nav-link {{ isset($activePage) && $activePage === 'devices' ? 'active' : '' }}">
        <i class="nav-icon fas fa-mobile-alt"></i>
        <p>Dispositivos</p>
    </a>
</li>
