@extends('templates.auth')

@section('content')
<div class="page page-center">
  <div class="container container-tight py-4">
    <div class="text-center mb-4">
      <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg" height="36" alt=""></a>
    </div>
    <div class="card card-md bg-transparent shadow-none border-0">
      <div class="card-body">
        <h2 class="h2 text-center mb-4">Fazer login na sua conta</h2>
        <form action="{{route('login.store')}}" method="post" autocomplete="off" novalidate>
          @csrf
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" placeholder="Digite seu email" name="email" value="{{old('email')}}" autocomplete="transaction-currency" required>
          </div>
          <div class="mb-2">
            <label class="form-label">
              Senha
              <span class="form-label-description">
                <a href="{{route('login.reset')}}">Esqueceu sua senha?</a>
              </span>
            </label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control" placeholder="Digite sua senha" name="password" id="password" value="{{old('password')}}" required>
              <span class="input-group-text">
                <a href="#" class="link-secondary text-decoration-none" onclick="change('password')">
                  <i class="ti ti-eye" style="font-size: 20px;"></i>
                </a>
              </span>
            </div>
          </div>
          <div class="form-footer d-flex">
            <button type="submit" class="btn btn-primary w-50 me-1">Fazer login</button>
            <a href="{{route('login.first')}}" class="btn btn-info w-50">Primeiro acesso</a>
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