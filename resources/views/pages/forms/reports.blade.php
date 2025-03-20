@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col-12 col-md">
          <div class="page-pretitle">
            <a href="{{ route('forms.create') }}">Formulários</a> /
            <a href="{{ route('forms.show', $form->id) }}">Relatório personalizado</a>
          </div>
          <h2 class="page-title">
            Relatório personalizado
          </h2>
        </div>
        <div class="d-flex align-items-center col-sm-12 col-md-auto">
        </div>
      </div>
    </div>
  </div>
  <div class="page-body container-xl">
    <div class="card">
      <div class="card-body">
        <form action="" method="post">
          @csrf
          <x-form-elements.select.select title="Deseja trazer os dados de todas as respostas?" id="role"
            name="status">
            <x-slot:options>
              <option value="" selected disabled>Selecione</option>
              <option value="1">Não</option>
              <option value="2">Sim</option>
            </x-slot:options>
          </x-form-elements.select.select>

          <div id="comment" style="display: none;">
            <hr class="mb-2 mt-2">
            <div class="mb-3">
              <label class="form-label">Título da ação parceira</label>
              <div class="d-flex gap-2">
                <select class="form-select" id="select_project" name="title_partner">
                  <option value="" selected>Selecione</option>
                  @foreach ($form->responses as $response)
                    <option value="{{ $response->id }}" data-title="{{ $response->action->title }}"
                      data-coordinator="{{ $response->coordinator_name }}">
                      {{ $response->action->title }}
                    </option>
                  @endforeach
                </select>
                <button type="button" class="btn btn-success" id="add_project">Adicionar</button>
              </div>
            </div>

            <!-- Input oculto para armazenar os IDs das respostas selecionadas -->
            <input type="hidden" id="responses_input" name="responses" value="">

            <table class="table">
              <thead>
                <tr>
                  <th>Título do projeto</th>
                  <th>Coordenador do projeto</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="responses_table_body">
              </tbody>
            </table>
          </div>

          <div class="d-flex">
            <button type="submit" class="btn btn-success ms-auto">Enviar</button>
          </div>
        </form>


        Se quer todos ou escolher entre as Respostas/
        Escolher quais campos devem vim/
        Escolher sobre quais status devem vim as respostas/

      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    // document.addEventListener("DOMContentLoaded", function() {
    //   var el = document.getElementById('select_project');
    //   if (el) {
    //     new TomSelect(el, {
    //       copyClassesToDropdown: false,
    //       dropdownParent: 'body',
    //       controlInput: '<input>',
    //       render: {
    //         item: function(data, escape) {
    //           return `<div>${escape(data.text)}</div>`;
    //         },
    //         option: function(data, escape) {
    //           return `<div>${escape(data.text)}</div>`;
    //         }
    //       }
    //     });
    //   }
    // });

    document.getElementById('role').addEventListener('change', function() {
      var commentDiv = document.getElementById('comment');
      var roleValue = this.value;

      if (roleValue == '1') {
        commentDiv.style.display = 'block';
      } else {
        commentDiv.style.display = 'none';
      }
    });

    if (document.getElementById('role').value == '2') {
      document.getElementById('comment').style.display = 'block';
    }

    document.addEventListener("DOMContentLoaded", function() {
      let selectProject = document.getElementById("select_project");
      let addProjectBtn = document.getElementById("add_project");
      let tableBody = document.getElementById("table_body");
      let responsesInput = document.getElementById("responses_input");
      let commentDiv = document.getElementById("comment");
      let roleSelect = document.getElementById("role");
      let selectedResponses = [];

      if (!selectProject || !addProjectBtn || !tableBody || !responsesInput || !commentDiv || !roleSelect) {
        console.error("Um ou mais elementos não foram encontrados no DOM.");
        return;
      }

      // Adiciona item à tabela
      addProjectBtn.addEventListener("click", function() {
        let selectedOption = selectProject.options[selectProject.selectedIndex];
        if (!selectedOption) return;

        let responseId = selectedOption.value;
        let title = selectedOption.getAttribute("data-title");
        let coordinator = selectedOption.getAttribute("data-coordinator");

        if (!responseId || selectedResponses.includes(responseId)) {
          return; // Evita valores duplicados ou inválidos
        }

        selectedResponses.push(responseId);
        responsesInput.value = selectedResponses.join(",");

        let newRow = `<tr data-id="${responseId}">
                        <td>${title}</td>
                        <td>${coordinator}</td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-response">Remover</button></td>
                      </tr>`;

        if (tableBody) {
          tableBody.insertAdjacentHTML("beforeend", newRow);
        }
      });

      // Remove item da tabela
      if (tableBody) {
        tableBody.addEventListener("click", function(event) {
          if (event.target.classList.contains("remove-response")) {
            let row = event.target.closest("tr");
            let responseId = row.getAttribute("data-id");

            selectedResponses = selectedResponses.filter(id => id !== responseId);
            responsesInput.value = selectedResponses.join(",");

            row.remove();
          }
        });
      }

      // Controla a exibição do bloco de respostas
      roleSelect.addEventListener("change", function() {
        if (this.value == "1") {
          commentDiv.style.display = "block";
        } else {
          commentDiv.style.display = "none";
          selectedResponses = [];
          responsesInput.value = "";
          tableBody.innerHTML = ""; // Limpa a tabela
        }
      });
    });
  </script>
@endsection
