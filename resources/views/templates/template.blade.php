<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Proex</title>
  <!-- CSS files -->

  @yield('styles')

  <link href="{{ asset('assets/css/tabler-icons.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/tabler.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/tabler-payments.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/tabler-vendors.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/demo.min.css') }}" rel="stylesheet" />
  <link rel="shortcut icon" href="{{ asset('assets/img/illustrations/logo-small.svg') }}" type="image/x-icon">


  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }
  </style>
</head>

<body>
  <script src="{{ asset('assets/js/demo-theme.min.js?1684106062') }}"></script>
  <!-- Spinner fullscreen -->
  <div id="loading-overlay"
    style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(3px); z-index: 9999; display: none; justify-content: center; align-items: center;">
    <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
      <span class="visually-hidden">Carregando...</span>
    </div>
  </div>
  <div class="page">
    <!-- Navbar -->
    <header class="navbar navbar-expand-md d-print-none">
      <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
          aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
          <a href="/dashboard">
            <img src="{{ asset('assets/img/ufca.png') }}" width="110" height="32" alt="tabler"
              class="navbar-brand-image">
          </a>
        </h1>
        <div class="navbar-nav flex-row order-md-last">
          <div class="d-none d-md-flex me-3">
            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Mudar para tema escuro"
              data-bs-toggle="tooltip" data-bs-placement="bottom">
              <i class="ti ti-moon icon"></i>
            </a>
            <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Mudar para tema claro"
              data-bs-toggle="tooltip" data-bs-placement="bottom">
              <i class="ti ti-sun icon"></i>
            </a>
          </div>
          <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
              aria-label="Open user menu">
              <span class="avatar avatar-sm">
                <i class="ti ti-user icon"></i>
              </span>
              <div class="d-none d-xl-block ps-2">
                <div>{{ strtok(Auth::user()->name, ' ') }}</div>
                <div class="mt-1 fs-6 text-muted">{{ ucfirst(Auth::user()->active_role) }}</div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <a href="{{ route('profile.index') }}" class="dropdown-item m-0">Perfil</a>
              <div class="dropdown-divider m-0"></div>
              <button data-bs-toggle="offcanvas" data-bs-target="#modal-modules"
                class="dropdown-item m-0">Portais</button>
              <div class="dropdown-divider m-0"></div>
              <a href="{{ route('logout') }}" class="dropdown-item">Sair</a>
            </div>
          </div>
        </div>
      </div>
    </header>
    <header class="navbar-expand-md">
      <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
          <div class="container-xl">
            <ul class="navbar-nav">
              <x-navbar.navbar-item route="{{ route('home.index') }}" title="Home"
                isActive="{{ request()->routeIs(['home.*']) ? true : false }}" icon="ti-home">
              </x-navbar.navbar-item>

              {{-- @can('ver_dashboard') --}}
              @if (Auth::user()?->activeRoleHasPermission('ver_dashboard'))
                <x-navbar.navbar-item route="{{ route('dashboard.index') }}" title="Dashboard"
                  isActive="{{ request()->routeIs(['dashboard.*']) ? true : false }}" icon="ti-chart-bar">
                </x-navbar.navbar-item>
              @endif
              {{-- @endcan --}}

              {{-- @can('ver_seus_projetos') --}}
              @if (Auth::user()?->activeRoleHasPermission('ver_seus_projetos'))
                <x-navbar.navbar-item route="{{ route('projects.my') }}" title="Meus Projetos"
                  isActive="{{ request()->routeIs(['projects.my', 'response.session', 'response.index']) ? true : false }}"
                  icon="ti-layout-dashboard">
                </x-navbar.navbar-item>
              @endif
              {{-- @endcan --}}

              {{-- @can('adicionar_formulário') --}}
              @if (Auth::user()?->activeRoleHasPermission('adicionar_formulário'))
                <x-navbar.navbar-item route="{{ route('forms.index') }}" title="Formulários"
                  isActive="{{ request()->routeIs(['forms.*', 'response.edit']) ? true : false }}"
                  icon="ti-clipboard-text">
                </x-navbar.navbar-item>
              @endif
              {{-- @endcan --}}

              {{-- @canany(['adicionar_cursos', 'adicionar_projetos']) --}}
              @if (Auth::user()?->activeRoleHasPermission('adicionar_cursos') ||
                      Auth::user()?->activeRoleHasPermission('adicionar_projetos'))
                <x-navbar.navbar-item route="" title="Cadastros"
                  isActive="{{ request()->routeIs(['courses.*', 'projects.index', 'projects.edit', 'projects.create', 'projects.import', 'projects.analysis']) ? true : false }}"
                  icon="ti-file-database">
                  <x-slot:links>

                    {{-- @can('adicionar_cursos') --}}
                    @if (Auth::user()?->activeRoleHasPermission('adicionar_cursos'))
                      <a class="dropdown-item" href="{{ route('courses.index') }}">Centros/Departamentos</a>
                    @endif
                    {{-- @endcan --}}

                    {{-- @can('adicionar_projetos') --}}
                    @if (Auth::user()?->activeRoleHasPermission('adicionar_projetos'))
                      <a class="dropdown-item" href="{{ route('projects.index') }}">Trabalhos</a>
                    @endif
                    {{-- @endcan --}}

                  </x-slot:links>
                </x-navbar.navbar-item>
              @endif
              {{-- @endcanany --}}

              {{-- @canany(['adicionar_usuário', 'adicionar_grupo', 'adicionar_permissões']) --}}
              @if (Auth::user()?->activeRoleHasPermission('adicionar_usuário') ||
                      Auth::user()?->activeRoleHasPermission('adicionar_grupo'))

                <x-navbar.navbar-item route="" title="Configurações"
                  isActive="{{ request()->routeIs(['users.*', 'roles.*', 'permissions.*', 'logs.*']) ? true : false }}"
                  icon="ti-settings">
                  <x-slot:links>
                    {{-- @can('adicionar_usuário') --}}
                    @if (Auth::user()?->activeRoleHasPermission('adicionar_usuário'))
                      <a class="dropdown-item" href="{{ route('users.index') }}">Usuários</a>
                    @endif
                    {{-- @endcan --}}
                    {{-- @can('adicionar_grupo') --}}
                    @if (Auth::user()?->activeRoleHasPermission('adicionar_grupo'))
                      <a class="dropdown-item" href="{{ route('roles.index') }}">Grupos</a>
                    @endif
                    @if (Auth::user()?->activeRoleHasPermission('ver_logs'))
                      <a class="dropdown-item" href="{{ route('logs.index') }}">Logs</a>
                    @endif
                    {{-- @endcan --}}
                  </x-slot:links>
                </x-navbar.navbar-item>
              @endif
              {{-- @endcanany --}}
            </ul>
          </div>
        </div>
      </div>
    </header>
    <div class="page-wrapper">

      <div class="container">
        @yield('content')
      </div>

      <footer class="footer footer-transparent d-print-none">
        <div class="container-xl">
          <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
              <ul class="list-inline list-inline-dots mb-0">
                <li class="list-inline-item"><a href="" target="_blank" class="link-secondary"
                    rel="noopener">Suport</a></li>
              </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
              <ul class="list-inline list-inline-dots mb-0">
                <li class="list-inline-item">
                  Copyright &copy; 2025
                  <a href="." class="link-secondary">Proex</a>.
                  All rights reserved.
                </li>
                <li class="list-inline-item">
                  <a href="./changelog.html" class="link-secondary" rel="noopener">
                    v2.0.0-beta
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>

    <x-modal.offcanvas id="modal-modules" class="offcanvas-start" title="Seus portais">
      <x-slot:content>
        <div class="row">
          @foreach (Auth::user()->roles as $role)
            <div class="col-12 col-md-6 p-1">
              <a href="{{ route('portal.change', $role->id) }}" class="card card-sm">
                <div class="card-body">
                  <div class="align-items-center">
                    <div class="text-center">
                      <span class="bg-primary text-white avatar">
                        <i class="icon ti ti-user"></i>
                      </span>
                      <div class="font-weight-medium">{{ $role->name }}</div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      </x-slot:content>
    </x-modal.offcanvas>
  </div>

  <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
  <script src="{{ asset('assets/js/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/js/tabler.min.js?1684106062') }}" defer></script>
  <script src="{{ asset('assets/js/demo.min.js?1684106062') }}" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  {{-- <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script> --}}
  @include('sweetalert::alert')
  @yield('scripts')

</body>

</html>
