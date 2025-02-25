<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Proex</title>
  <!-- CSS files -->
  <link href="{{ asset('assets/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/tabler-flags.min.css?1684106062') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/tabler-payments.min.css?1684106062') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/tabler-vendors.min.css?1684106062') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/demo.min.css?1684106062') }}" rel="stylesheet" />
  <link rel="shortcut icon" href="{{ asset('assets/img/illustrations/logo-small.svg') }}" type="image/x-icon">
  <link href="{{ asset('assets/css/tabler-icons.min.css') }}" rel="stylesheet" />

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

<body class="row m-0 p-0 vh-100">
  <div class="d-none d-lg-flex col-6 flex-wrap justify-content-center align-content-center bg-primary bg-gradient">
    <img src="{{ asset('assets/img/illustrations/login.svg') }}" class="w-75" alt="">
  </div>
  <div class="col-12 col-lg-6 bg-white">
    @yield('content')
  </div>

  <script src="{{ asset('assets/js/demo-theme.min.js?1684106062') }}"></script>
  <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>

  <script src="{{ asset('assets/js/tabler.min.js?1684106062') }}" defer></script>
  <script src="{{ asset('assets/js/demo.min.js?1684106062') }}" defer></script>
  <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
  <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
  <script>
    function change(id) {
      const input = document.getElementById(id);

      if (input.type === 'password') {
        input.type = 'text';
      } else {
        input.type = 'password';
      }

    }
  </script>
  @include('sweetalert::alert')
  @yield('scripts')

</body>

</html>
