@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('forms.index') }}">Forms</a>
          </div>
          <h2 class="page-title">
            {{ $form ? "$form->title | Prazo: " . date('d/m/Y', strtotime($form->date)) : 'Formulário indisponível' }}
          </h2>
        </div>
        <div class="col-auto ms-auto">
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    @if ($form)
      <div class="card">
        <div class="card-body">
          <ol class="breadcrumb">
            @foreach ($steps as $key => $step)
            <li class="breadcrumb-item 
            {{ $key == 1 || $key <= session('step') ? 'text-primary' : 'disabled' }} 
            {{ session('step') == $key ? 'active' : '' }}">
        
            <a type="button" class="text-decoration-hover-underline cursor-pointer"
                onclick="show({{ $key }})">
                {{ $key }}ª Seção
            </a>
        </li>
            @endforeach
          </ol>
        </div>
      </div>

      @if (session()->has('step'))
        <p>Passo atual: {{ session('step') }}</p>
      @endif

      <div class="card mt-3 card-form-step {{ !session()->has('step') || session('step') == 1 ? '' : 'd-none' }}"
        id="card-1">
        <div class="card-header">
          <h3 class="p-0 m-0">Título da ação de extensão</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('forms.persist') }}" method="post">
            @csrf
            @include('components.form-elements.input.input', [
                'title' => 'Título da ação',
                'type' => 'text',
                'class' => 'mb-3',
                'name' => 'title_action',
                'required' => 'true',
                'placeholder' => 'Digite o título da ação',
                'value' => isset($response->title_action) ? $response->title_action : '',
            ])

            <x-form-elements.select.select title="Tipo da ação" id="role" name="type_action">
              <x-slot:options>
                <option value="" selected>Selecione</option>
                <option value="Programa"
                  {{ isset($response->type_action) ? ($response->type_action == 'Programa' ? 'selected' : '') : '' }}>
                  Programa</option>
                <option value="Projeto"
                  {{ isset($response->type_action) ? ($response->type_action == 'Projeto' ? 'selected' : '') : '' }}>
                  Projeto
                </option>
              </x-slot:options>
            </x-form-elements.select.select>

            <x-form-elements.select.select title="Modalidade da ação" id="role" name="action_modality">
              <x-slot:options>
                <option value="" selected>Selecione</option>

                <option value="UFCA Itinerante"
                  {{ isset($response->action_modality) ? ($response->action_modality == 'UFCA Itinerante' ? 'selected' : '') : ' ' }}>
                  UFCA Itinerante</option>

                <option value="Ampla Concorrência"
                  {{ isset($response->action_modality) ? ($response->action_modality == 'Ampla Concorrência' ? 'selected' : '') : ' ' }}>
                  Ampla Concorrência</option>

                <option value="PROPE"
                  {{ isset($response->action_modality) ? ($response->action_modality == 'PROPE' ? 'selected' : '') : ' ' }}>
                  PROPE</option>
              </x-slot:options>
            </x-form-elements.select.select>
            <div class="d-flex">
              <button type="submit" class="btn btn-info ms-auto">Avançar</button>
            </div>
          </form>
        </div>
      </div>

      <div class="card mt-3 card-form-step {{ session()->has('step') && session('step') == 2 ? '' : 'd-none' }}"
        id="card-2">
        <div class="card-header">
          <h3 class="p-0 m-0">Dados do coordenador/tutor da ação de extensão</h3>
        </div>
        <div class="card-body">
          @include('components.form-elements.input.input', [
              'title' => 'Nome',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])

          <x-form-elements.select.select title="Perfil" id="role" name="role">
            <x-slot:options>
              <option value="" selected>Selecione</option>
              <option value="">Docente</option>
              <option value="">Técnico Administrativo</option>
              <option value="">Discente</option>
            </x-slot:options>
          </x-form-elements.select.select>

          @include('components.form-elements.input.input', [
              'title' => 'SIAPE (Obrigatória para Docente ou Técnico Administrativo)',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])

          <x-form-elements.select.select title="Curso" id="role" name="role">
            <x-slot:options>
              <option value="" selected>Selecione</option>
              <option value="">Administração</option>
              <option value="">Administração Pública e Gestão Social</option>
              <option value="">Biblioteconomia</option>
              <option value="">Ciências Contábeis</option>
              <option value="">Ciência da Computação</option>
              <option value="">Engenharia Civil</option>
              <option value="">Engenharia de Materiais</option>
              <option value="">Matemática Computacional</option>
              <option value="">Design</option>
              <option value="">Filosofia (Bacharelado)</option>
              <option value="">Filosofia (Licenciatura)</option>
              <option value="">Jornalismo</option>
              <option value="">Letras / Libras</option>
              <option value="">Música</option>
              <option value="">Agronomia</option>
              <option value="">Medicina Veterinária</option>
              <option value="">Licenciatura Interdisciplinar em Ciências Naturais e Matemática</option>
              <option value="">Pedagogia</option>
              <option value="">Física</option>
              <option value="">Química</option>
              <option value="">Biologia</option>
              <option value="">Matemática</option>
              <option value="">Medicina</option>
            </x-slot:options>
          </x-form-elements.select.select>
        </div>
      </div>

      <div class="card mt-3 card-form-step {{ session()->has('step') && session('step') == 3 ? '' : 'd-none' }}"
        id="card-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Detalhamento de atividades</h3>
        </div>
        <div class="card-body">
          @include('components.form-elements.textarea.textarea', [
              'title' => 'Liste e Descreva as Atividades Realizadas',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])
          @include('components.form-elements.textarea.textarea', [
              'title' => 'Quais os locais onde as atividades foram realizadas?  ',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])
        </div>
      </div>

      <div class="card mt-3 d-none card-form-step" id="card-4">
        <div class="card-header">
          <h3 class="p-0 m-0">Identificação e quantitativo do público beneficiado</h3>
        </div>
        <div class="card-body">
          @include('components.form-elements.input.input', [
              'title' => 'Total do público interno à UFCA',
              'type' => 'number',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])
          @include('components.form-elements.input.input', [
              'title' => 'Total do público externo à UFCA',
              'type' => 'number',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])
        </div>
      </div>

      <div class="card mt-3 d-none card-form-step" id="card-5">
        <div class="card-header">
          <h3 class="p-0 m-0">Avanços alcançados e impactos da ação extensionista</h3>
        </div>
        <div class="card-body">
          @include('components.form-elements.textarea.textarea', [
              'title' => 'Descreva os avanços alcançados e impactos da ação extensionista',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])
        </div>
      </div>

      <div class="card mt-3 d-none card-form-step" id="card-6">
        <div class="card-header">
          <h3 class="p-0 m-0">Parcerias Internas</h3>
        </div>
        <div class="card-body">
          <h4>DESCRIÇÃO DAS PARCERIAS INTERNAS FIRMADAS DURANTE O PERÍODO DE REALIZAÇÃO DA AÇÃO</h4>

          <x-form-elements.select.select title=" Título da ação parceira" id="role" name="role">
            <x-slot:options>
              <option value="" selected>Selecione</option>
              @foreach ($base as $item)
                <option value="">{{ $item }}</option>
              @endforeach
            </x-slot:options>
          </x-form-elements.select.select>
        </div>
      </div>

      <div class="card mt-3 d-none card-form-step" id="card-7">
        <div class="card-header">
          <h3 class="p-0 m-0">Parcerias externas</h3>
        </div>
        <div class="card-body">
          <h4>DESCRIÇÃO DAS PARCERIAS EXTERNAS FIRMADAS DURANTE O PERÍODO DE REALIZAÇÃO DA AÇÃO</h4>
          @include('components.form-elements.input.input', [
              'title' => 'Nome do Parceiro',
              'type' => 'number',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])
          <x-form-elements.select.select title="Tipo de Instituição" id="role" name="role">
            <x-slot:options>
              <option value="" selected>Selecione</option>
              <option value="">Movimento Social Organizado (MSO)</option>
              <option value="">Privado (PR)</option>
              <option value="">Público Municipal (PM)</option>
              <option value="">Público Estadual (PE)</option>
              <option value="">Público Federal (PF)</option>
            </x-slot:options>
          </x-form-elements.select.select>
          <x-form-elements.select.select title="Tipo de Parceria*" id="role" name="role">
            <x-slot:options>
              <option value="" selected>Selecione</option>
              <option value="">Cooperação (CP)</option>
              <option value="">Convênio (CV)</option>
              <option value="">Contrato (CT)</option>
            </x-slot:options>
          </x-form-elements.select.select>
        </div>
      </div>

      <div class="card mt-3 d-none card-form-step" id="card-8">
        <div class="card-header">
          <h3 class="p-0 m-0">Ações vinculadas ao programa de extensão</h3>
        </div>
        <div class="card-body">
          @include('components.form-elements.textarea.textarea', [
              'title' => 'Liste os títulos das Ações que se articulam ao Programa de Extensão',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])

          <x-form-elements.select.select title="A Ação é voltada para escolas públicas? " id="role"
            name="role">
            <x-slot:options>
              <option value="" selected>Selecione</option>
              <option value="">Sim</option>
              <option value="">Não</option>
            </x-slot:options>
          </x-form-elements.select.select>
          @include('components.form-elements.textarea.textarea', [
              'title' => 'A Ação estabeleceu parceria internacional? Se sim, descreva',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])
        </div>
      </div>

      <div class="card mt-3 d-none card-form-step" id="card-9">
        <div class="card-header">
          <h3 class="p-0 m-0">A ação atuou com o desenvolvimento de alguma tecnologia social</h3>
        </div>
        <div class="card-body">
          @include('components.form-elements.textarea.textarea', [
              'title' => 'A Ação atuou com o Desenvolvimento de alguma Tecnologia Social? Se sim, descreva',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])
        </div>
      </div>

      <div class="card mt-3 d-none card-form-step" id="card-10">
        <div class="card-header">
          <h3 class="p-0 m-0">Redes sociais criadas para o programa/projeto</h3>
        </div>
        <div class="card-body">
          @include('components.form-elements.textarea.textarea', [
              'title' => 'Liste os dados das redes sociais criadas para o programa/projeto:',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])
        </div>
      </div>

      <div class="card mt-3 d-none card-form-step" id="card-11">
        <div class="card-header">
          <h3 class="p-0 m-0">Disposições finais</h3>
        </div>
        <div class="card-body">
          @include('components.form-elements.textarea.textarea', [
              'title' =>
                  'Como a equipe avalia este instrumento de monitoramento? Sugere a abordagem de alguma questão que não esteve aqui ou que seja abordado de outra forma? Tem mais alguma crítica e/ou sugestões que deseja fazer à equipe da PROEX?',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])
          @include('components.form-elements.textarea.textarea', [
              'title' =>
                  'Com relação às imagens submetidas na pergunta anterior, informe aqui as legendas de cada um informando local, data e descrição da atividade. Por exemplo: "Foto 1 - Participação no evento X no Colégio Y do município Z. 20/10/2023".',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'email',
              'required' => 'true',
              'placeholder' => 'Digite o seu nome',
          ])
        </div>
      </div>
    @else
      <div class="alert alert-info">Nenhum formulário disponível!</div>
    @endif
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script>
    function show(id) {
      let divs = document.getElementsByClassName('card-form-step');

      for (let el of divs) {
        el.classList.add('d-none');
      }
      let div = document.getElementById(`card-${id}`);
      if (div) {
        div.classList.remove('d-none');
      }
    }
  </script>
@endsection
