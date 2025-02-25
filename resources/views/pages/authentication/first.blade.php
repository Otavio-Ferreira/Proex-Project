@extends('templates.auth')

@section('content')
  <div class="page page-center">
    <div class="container container-tight py-4">
      <div class="text-center mb-4">
        <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg" height="36"
            alt=""></a>
      </div>
      <div class="card card-md bg-transparent shadow-none border-0">
        <div class="card-body">
          <h2 class="h2 text-center mb-4">Primeiro acesso</h2>
          <form action="{{ route('login.fill') }}" method="post" autocomplete="off" novalidate>
            @csrf
            <div class="mb-3">
              <label class="form-label">Nome</label>
              <input type="text" class="form-control" placeholder="Digite seu nome" name="name"
                value="{{ old('name') }}" autocomplete="transaction-currency" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" placeholder="Digite seu email institucional" name="email"
                value="{{ old('email') }}" id="email" autocomplete="transaction-currency" required>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">Registrar</button>
            </div>
          </form>
          <div class="text-center text-muted mt-3">
            Esquecer, <a href="{{ route('login') }}">me envie de volta</a> para a página de login.
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
@endsection