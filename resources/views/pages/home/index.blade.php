@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('home.index') }}">Home</a>
          </div>
          <h2 class="page-title">
            Home
          </h2>
        </div>
        <div class="col-auto ms-auto">
        </div>
      </div>
    </div>
  </div>
  <div class="page-body row">
    @if (!$person)
      <div class="row">
        <div class="col-12 col-md-6">
          <img src="{{ asset('assets/img/illustrations/funny.svg') }}" alt="">
        </div>
        <div class="col-12 col-md-6">
          <h1>Olá, <span class="text-primary">{{ $user->name }}</span> Seja bem vindo ao sistema de PROEX!</h1>
          <h3>Para continuar precisamos que você clique no botão abaixo para completar o seu cadastro.</h3>
          <a href="{{ route('profile.index') }}" class="btn btn-primary">Completar Cadastro</a>
        </div>
      </div>
    @else
      <div class="col-sm-12 col-md-8">
        <div class="mb-3">
          <h3>Tarefas</h3>
          <div class="card border-0">
            @if (count($tasks) > 0)
              <ol class="list-group list-group-numbered">
                @foreach ($tasks as $task)
                  <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                      <div class="fw-bold">{{ $task['description'] }}</div>
                      @if ($task['type'] == 1)
                        O relatório do projeto {{ $task['response']->project->title }} está em {{ $task['progress'] }}%
                      @else
                        O usuário {{ $task['user']->name }} aguarda.
                      @endif
                    </div>
                    @if ($task['type'] == 1)
                      <a href="{{ route('response.index', $task['response']->id) }}" class="badge text-bg-primary">Ir</a>
                    @else
                      <a href="{{ route('users.index') }}" class="badge text-bg-primary">Ir</a>
                    @endif
                  </li>
                @endforeach
              </ol>
            @else
              <div class="alert mb-0">
                Você não tem tarefas
              </div>
            @endif
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">Perfil Atualizado há</div>
            </div>
            <div class="h1 mb-3">{{ $user->updated_at->diffForHumans() }}</div>
            <div class="d-flex mb-2">
              <div>Nível de segurança do perfil</div>
              <div class="ms-auto">
                <span
                  class="d-inline-flex align-items-center lh-1
                  {{ $user->updated_at->diffInMonths() < 2 ? 'text-green' : ($user->updated_at->diffInMonths() < 4 ? 'text-warning' : 'text-danger') }}
                ">
                  {{ $progress }}
                </span>
              </div>
            </div>
            <div class="progress progress-sm">
              <div
                class="progress-bar {{ $user->updated_at->diffInMonths() < 2 ? 'bg-green' : ($user->updated_at->diffInMonths() < 4 ? 'bg-warning' : 'bg-danger') }}"
                style="width: {{ $progress }}" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <span class="visually-hidden">{{ $progress }}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="card mt-3">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="h1 mb-0">Perfil {{ $profile < 100 ? 'Incompleto' : 'Completo' }}</div>
              <a class="btn btn-sm btn-primary rounded-2" id="sales-dropdown"
                href="{{ route('profile.index') }}">{{ $profile < 100 ? 'Completar perfil' : 'Acessar perfil' }}</a>
            </div>
            <div class="d-flex mb-2">
              <div>Quantidade completa</div>
              <div class="ms-auto">
                <span
                  class="d-inline-flex align-items-center lh-1
                  {{ $profile == 100 ? 'text-green' : ($profile > 60 ? 'text-warning' : 'text-danger') }}
                ">
                  {{ $profile }}%
                </span>
              </div>
            </div>
            <div class="progress progress-sm">
              <div class="progress-bar {{ $profile == 100 ? 'bg-green' : ($profile > 60 ? 'bg-warning' : 'bg-danger') }}"
                style="width: {{ $profile }}%" aria-valuenow="{{ $profile }}" role="progressbar"
                aria-valuemin="0" aria-valuemax="100">
                <span class="visually-hidden">{{ $profile }}%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endsection
