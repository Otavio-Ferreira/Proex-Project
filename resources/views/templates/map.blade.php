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
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  <style>
    #map {
      height: 600px;
      width: 100%;
    }
  </style>
</head>

<body class="row m-0 p-0 vh-100">
  <div class="p-4 d-lg-flex flex-wrap justify-content-center align-content-center">
    <div class="modal-body text-center py-4">
      <h3>Mapa da Extensão - UFCA</h3>
      <div id="map" class="w-100"></div>
    </div>
  </div>

  @foreach ($projects as $project)
    <x-modal.offcanvas id="modal-details-{{ $project->id }}" class="offcanvas-end" title="Detalhes">
      <x-slot:content>
        <ul class="list-group list-group-flush">
          <li class="list-group-item {{ $project->title ?? 'text-danger' }}"><strong>Título:</strong>
            {{ $project->title ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->type ?? 'text-danger' }}"><strong>Tipo:</strong>
            {{ $project->type ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->modality ?? 'text-danger' }}"><strong>Modalidade:</strong>
            {{ $project->modality ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->thematic_area ?? 'text-danger' }}"><strong>Área temática:</strong>
            {{ $project->thematic_area ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->course_name->name ?? 'text-danger' }}">
            <strong>Centro/Departamento:</strong>
            {{ $project->course_name->name ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->user->name ?? 'text-danger' }}"><strong>Coordenador:</strong>
            {{ $project->user->name ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->year ? '' : 'text-danger' }}"><strong>Ano:</strong>
            {{ $project->year ? date('Y', strtotime($project->year)) : 'Vazio' }}</li>
          <li class="list-group-item"><strong>Status:</strong>
            {{ $project->status == 0 ? 'Inativo' : ($project->status == 1 ? 'Ativo' : 'Finalizado') }}</li>
        </ul>
        <div class="w-100">
            <h3>Imagens das atividades</h3>
            @foreach ($project->responses as $response)
              @if ($response->images && $response->images->count() > 0)
                @foreach ($response->images as $image)
                  <img src="{{ asset($image->image) }}" alt="Imagem" class="w-100 mt-2">
                @endforeach
              @endif
            @endforeach
        </div>

      </x-slot:content>
    </x-modal.offcanvas>
  @endforeach

  <script src="{{ asset('assets/js/demo-theme.min.js?1684106062') }}"></script>
  <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>

  <script src="{{ asset('assets/js/tabler.min.js?1684106062') }}" defer></script>
  <script src="{{ asset('assets/js/demo.min.js?1684106062') }}" defer></script>
  <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
  <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <script>
    const map = L.map('map').setView([-5.2, -39.3], 7); // Ajuste a localização central

    // Adiciona o mapa base (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Dados vindos do Laravel
    const markers = @json($markers);

    // Adiciona marcadores no mapa
    markers.forEach(marker => {
      const popupContent = `
            <strong>Endereço:</strong> ${marker.address}<br>
            <strong>Título:</strong> ${marker.title}<br>
            <button class="btn w-100 btn-primary mt-2"
            data-bs-toggle="offcanvas"
            data-bs-target="#modal-details-${marker.id}">
            Ver detalhes
            </button>
        `;

      L.marker([marker.lat, marker.lng])
        .addTo(map)
        .bindPopup(popupContent);
    });
  </script>
</body>

</html>
