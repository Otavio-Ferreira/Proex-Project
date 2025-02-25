@extends('templates.auth')

@section('content')

<div class="page page-center">
  <div class="container container-tight py-4">
    <div class="text-center mb-4">
      <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg" height="36" alt=""></a>
    </div>
    <div class="card card-md bg-transparent shadow-none border-0">
      <div class="card-body">
        <h2 class="h2 text-center mb-4">Digite sua nova senha</h2>
        <form action="{{route('login.update', $token_id)}}" method="post" autocomplete="off" novalidate>
          @csrf
          <div class="mb-3">
            <label class="form-label">
              Nova Senha
            </label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control" name="password" id="password" value="{{old('password')}}" placeholder="Digite a nova senha" required>
              <span class="input-group-text">
                <a href="#" class="link-secondary text-decoration-none" onclick="change('password')">
                  <i class="ti ti-eye" style="font-size: 20px;"></i>
                </a>
              </span>
            </div>
          </div>
          <div class="mb-2">
            <label class="form-label">
              Confirmar senha
            </label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="{{old('password_confirm')}}" placeholder="Confirme a nova senha" required>
              <span class="input-group-text">
                <a href="#" class="link-secondary text-decoration-none" onclick="change('password_confirm')">
                  <i class="ti ti-eye" style="font-size: 20px;"></i>
                </a>
              </span>
            </div>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Resetar senha</button>
          </div>
        </form>
      </div>
    </div>
    <div class="text-center text-muted mt-3">
      Desenvolvido por <a href="" tabindex="-1">Otavio Ferreira</a>
    </div>
  </div>
</div>

@endsection