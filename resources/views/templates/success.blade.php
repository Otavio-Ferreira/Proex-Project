<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Proex</title>
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
  <div class="p-4 d-lg-flex flex-wrap justify-content-center align-content-center">
    <div class="modal-body text-center py-4">
      <i class="ti ti-square-rounded-check icon mb-2 text-green icon-lg"></i>
      <h3>Sucesso!</h3>
      <div class="text-secondary">
        @if (session('message'))
          <div class="text-success">
            {{ session('message') }}
          </div>
        @endif
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/js/demo-theme.min.js?1684106062') }}"></script>
  <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>

  <script src="{{ asset('assets/js/tabler.min.js?1684106062') }}" defer></script>
  <script src="{{ asset('assets/js/demo.min.js?1684106062') }}" defer></script>
  <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
  <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
</body>

</html>
