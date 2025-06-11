@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('dashboard.index') }}">Dashboard</a>
          </div>
          <h2 class="page-title">
            Dashboard
          </h2>
        </div>
        <div class="col-auto ms-auto">
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    @if (!$person)
      <div class="row">
        <div class="col-12 col-md-6">
          <img src="{{ asset('assets/img/illustrations/funny.svg') }}" alt="">
        </div>
        <div class="col-12 col-md-6">
            <h1>Olá, <span class="text-primary">{{$user->name}}</span> Seja bem vindo ao sistema de PROEX!</h1>
            <h3>Para continuar precisamos que você clique no botão abaixo para completar o seu cadastro.</h3>
            <a href="{{route('profile.index')}}" class="btn btn-primary">Completar Cadastro</a>
        </div>
      </div>
    @endif
    @can('ver_dashboard')
    @endcan
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endsection
