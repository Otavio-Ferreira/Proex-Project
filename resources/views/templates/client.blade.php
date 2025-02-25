<!doctype html>
<html lang="en">

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
  <link href="{{ asset('assets/libs/apexcharts/dist/apexcharts.css') }}" rel="stylesheet" />

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
  <div class="page">
    <!-- Navbar -->
    <header class="navbar p-2">
      <div class="container-xl navbar-expand-md d-print-none">
        @if (request()->routeIs(['construction.*']))
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        @else
          <a href="{{ route('construction.show', [strtolower(str_replace(' ', '_', $obra->CLIENTE)),$obra->COD_UNIQUE]) }}" class="text-decoration-none text-dark"><i
              class="ti ti-chevron-left fs-1"></i></a>
        @endif

        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
          <a href="{{ route('construction.show', [strtolower(str_replace(' ', '_', $obra->CLIENTE)),$obra->COD_UNIQUE]) }}" class="text-decoration-none">
            @if (request()->routeIs(['construction.*']))
                Minha Obra
            @else
                {{$info['title_page']}}
            @endif

          </a>
        </h1>
        <div class="navbar-nav flex-row order-md-last">
          <div class="nav-item dropdown">
            <a href="{{ route('construction.show', [strtolower(str_replace(' ', '_', $obra->CLIENTE)),$obra->COD_UNIQUE])  }}" class="nav-link d-flex lh-1 text-reset p-0 "
              data-bs-toggle="dropdown" aria-label="Open user menu">
              <img src="{{ asset('assets/img/illustrations/logo-small.svg') }}" class="rounded-5" alt="">
            </a>
          </div>
        </div>
      </div>
      {{-- <div class="container-xl mt-2 mb-2">
        <div class="input-icon w-100">
          <span class="input-icon-addon">
            <i class="ti ti-search"></i>
          </span>
          <input type="text" value="" class="w-100 form-control form-control-rounded border-0"
            placeholder="Pesquisar" style="background: #F5F7FA; height: 40px;">
        </div>
      </div> --}}
    </header>
    @if (request()->routeIs(['construction.*']))
      <header class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar">
            <div class="container-xl">
              <ul class="navbar-nav">

                <x-navbar.navbar-item route="#evolucao" isActive="{{ request()->routeIs(['home.*']) ? true : false }}"
                  title="Evolução" icon="ti-trending-up">
                </x-navbar.navbar-item>
                <x-navbar.navbar-item route="#cronograma" isActive="{{ request()->routeIs(['home.*']) ? true : false }}"
                  title="Cronograma" icon="ti-clock-hour-10">
                </x-navbar.navbar-item>
                <x-navbar.navbar-item route="#orcameto" isActive="{{ request()->routeIs(['home.*']) ? true : false }}"
                  title="Orçamento" icon="ti-presentation-analytics">
                </x-navbar.navbar-item>
                <x-navbar.navbar-item route="#custos" isActive="{{ request()->routeIs(['home.*']) ? true : false }}"
                  title="Custos" icon="ti-coin">
                </x-navbar.navbar-item>

              </ul>
            </div>
          </div>
        </div>
      </header>
    @endif
    <div class="page-wrapper">

      <div class="container-xl">
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
                  Copyright &copy; 2024
                  <a href="." class="link-secondary">Araripe Softwares</a>.
                  All rights reserved.
                </li>
                <li class="list-inline-item">
                  <a href="./changelog.html" class="link-secondary" rel="noopener">
                    v1.0.0-beta
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/js/echarts.min.js') }}"></script>
  <script src="{{ asset('assets/js/tabler.min.js?1684106062') }}" defer></script>
  <script src="{{ asset('assets/js/demo.min.js?1684106062') }}" defer></script>
  @include('sweetalert::alert')
  @yield('scripts')

</body>

</html>
