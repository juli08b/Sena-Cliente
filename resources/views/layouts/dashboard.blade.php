<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel') · Sena-Cliente</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css?v=' . time()) }}">
    <link rel="stylesheet" href="{{ asset('css/form-style.css?v=' . time()) }}">
    @stack('styles')
</head>
<body>
    <div class="admin-root" id="adminRoot">

        @php
            // Este cliente no tiene autenticación propia: la sesión se muestra solo
            // si existe y si no, el panel queda en modo lectura.
            $user = Auth::user();
            $current = request()->route()?->getName();
            $pageTitle = trim(strip_tags($__env->yieldContent('title') ?? '')) ?: 'Panel';
        @endphp

        {{-- Backdrop para móvil --}}
        <div class="admin-sidebar-backdrop" id="sidebarBackdrop"></div>

        {{-- ═══════════════ SIDEBAR ═══════════════ --}}
        <aside class="admin-sidebar">
            <a href="{{ route('areas.index') }}" class="admin-sidebar-brand text-decoration-none" title="Ir al inicio">
                <span class="admin-sidebar-logo">
                    <i class="bi bi-mortarboard-fill"></i>
                </span>
                <span>
                    <span class="admin-sidebar-title d-block">Sena-Cliente</span>
                    <span class="admin-sidebar-subtitle">Gestión Académica</span>
                </span>
            </a>

            <nav class="admin-sidebar-nav">
                <div class="admin-nav-section">Administración</div>

                @php
                    $adminGroups = [
                        [
                            'label' => 'Gestión de datos',
                            'icon'  => 'bi-table',
                            'items' => [
                                ['route' => 'training-centers.index', 'icon' => 'bi-building',    'label' => 'Ambientes de formación'],
                                ['route' => 'areas.index',             'icon' => 'bi-box-seam',    'label' => 'Programas de formación'],
                                ['route' => 'computers.index',         'icon' => 'bi-pc-display',  'label' => 'Computadores'],
                                ['route' => 'teachers.index',          'icon' => 'bi-person-badge','label' => 'Instructores'],
                                ['route' => 'courses.index',           'icon' => 'bi-journal-bookmark', 'label' => 'Cursos'],
                                ['route' => 'course-teachers.index',   'icon' => 'bi-link-45deg',  'label' => 'Asignaciones'],
                                ['route' => 'apprentices.index',       'icon' => 'bi-people',      'label' => 'Aprendices'],
                            ],
                        ],
                    ];
                @endphp

                @foreach($adminGroups as $group)
                    @php
                        $groupActive = collect($group['items'])->contains('route', $current);
                    @endphp
                    <div class="nav-item">
                        <button type="button"
                                class="admin-nav-toggle"
                                data-bs-toggle="collapse"
                                data-bs-target="#group-{{ \Illuminate\Support\Str::slug($group['label']) }}"
                                aria-expanded="{{ $groupActive ? 'true' : 'false' }}">
                            <span class="admin-nav-toggle-inner">
                                <span class="admin-nav-icon"><i class="bi {{ $group['icon'] }}"></i></span>
                                {{ $group['label'] }}
                            </span>
                            <span><i class="bi {{ $groupActive ? 'bi-chevron-down' : 'bi-chevron-right' }}"></i></span>
                        </button>
                        <div id="group-{{ \Illuminate\Support\Str::slug($group['label']) }}"
                             class="admin-nav-sub collapse @if($groupActive) show @endif">
                            @foreach($group['items'] as $item)
                                <a href="{{ route($item['route']) }}"
                                   class="admin-nav-link @if($current === $item['route']) active @endif">
                                    <span class="admin-nav-icon"><i class="bi {{ $item['icon'] }}"></i></span>
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>

            <div class="admin-sidebar-footer">
                <a href="{{ route('areas.index') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-2">
                    <i class="bi bi-globe2"></i>
                    <span>Programas de formación</span>
                </a>
                <strong>SENA</strong>
                <span>Más formación, más oportunidades.</span>
            </div>
        </aside>

        {{-- ═══════════════ MAIN ═══════════════ --}}
        <div class="admin-main">
            <header class="admin-topbar">
                <button type="button" class="admin-topbar-icon d-lg-none" id="sidebarToggle" aria-label="Abrir menú">
                    <i class="bi bi-list"></i>
                </button>

                <div class="admin-topbar-search">
                    <i class="bi bi-search" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--muted);"></i>
                    <input type="search" placeholder="Buscar programas, ambientes, computadores..." aria-label="Buscar registros visibles" autocomplete="off">
                </div>

                <div class="admin-topbar-actions">
                    <a href="{{ route('areas.index') }}" class="admin-topbar-btn {{ $current === 'areas.index' ? 'active' : '' }}"
                       title="Ir al listado">
                        <i class="bi bi-house-door-fill"></i><span class="d-none d-md-inline">Inicio</span>
                    </a>
                </div>

                <div class="position-relative">
                    @if ($user)
                        <button type="button" class="admin-topbar-user btn" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="admin-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            <span class="text-start d-none d-sm-block">
                                <span class="admin-user-name d-block">{{ $user->name }}</span>
                                <span class="admin-user-role d-block">Administrador</span>
                            </span>
                            <span class="d-none d-sm-block"><i class="bi bi-chevron-down"></i></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @else
                        <span class="admin-topbar-user btn" aria-label="Cuenta">
                            <span class="admin-avatar"><i class="bi bi-person-fill"></i></span>
                        </span>
                    @endif
                </div>
            </header>

            <main class="admin-content">
                @if ($current !== 'areas.index')
                    <nav class="dash-breadcrumb" aria-label="breadcrumb">
                        <a href="{{ route('areas.index') }}"><i class="bi bi-house-door-fill"></i>Inicio</a>
                        <span class="dash-breadcrumb-sep">/</span>
                        <span class="dash-breadcrumb-current">{{ $pageTitle }}</span>
                    </nav>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/ajax-forms.js') }}"></script>
    <script src="{{ asset('js/panel-search.js') }}"></script>
    <script>
        (function () {
            const root = document.getElementById('adminRoot');
            const toggle = document.getElementById('sidebarToggle');
            const backdrop = document.getElementById('sidebarBackdrop');

            const open = () => root.classList.add('sidebar-open');
            const close = () => root.classList.remove('sidebar-open');

            if (toggle) { toggle.addEventListener('click', open); }
            if (backdrop) { backdrop.addEventListener('click', close); }

            document.querySelectorAll('.admin-sidebar .admin-nav-link').forEach(function (link) {
                link.addEventListener('click', close);
            });
        })();
    </script>
</body>
</html>
