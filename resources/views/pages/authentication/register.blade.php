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
          <form action="{{ route('login.update', $token_id) }}" method="post" autocomplete="off" novalidate>
            @csrf
            <div class="mb-3">
              <label class="form-label">
                Crie uma Senha
              </label>
              <div class="input-group input-group-flat">
                <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}"
                  placeholder="Crie uma senha" required>
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
                <input type="password" class="form-control" name="password_confirm" id="password_confirm"
                  value="{{ old('password_confirm') }}" placeholder="Confirme a senha" required>
                <span class="input-group-text">
                  <a href="#" class="link-secondary text-decoration-none" onclick="change('password_confirm')">
                    <i class="ti ti-eye" style="font-size: 20px;"></i>
                  </a>
                </span>
              </div>
              <span class="d-none" id="divMessage" style="font-size: 12px;color: #dd6e6e;">As duas senhas precisam ser
                iguais.</span>
            </div>
            <div class="col-md-12 mt-1">
              Requisitos de senha: <br>
              <span style="font-size: 12px;color: #a9a6a6;">
                <span id="number">Números</span><br>
                <span id="lower">Letras minusculas</span><br>
                <span id="upper">Letras maiúsculas</span><br>
                <span id="character">Caracteres especiais</span><br>
                <span id="qtd_character">No mínimo 8 caracteres</span><br>
              </span>
            </div>
            <div class="form-footer">
              <button type="submit" class="btn btn-primary w-100">Registrar senha</button>
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
@section('scripts')
  <script>
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("password_confirm");
    const divMessage = document.getElementById("divMessage");

    const number = document.getElementById("number");
    const lower = document.getElementById("lower");
    const upper = document.getElementById("upper");
    const character = document.getElementById("character");
    const qtdCharacter = document.getElementById("qtd_character");

    function validatePasswordStrength(password) {
      const hasNumber = /\d/.test(password);
      const hasLower = /[a-z]/.test(password);
      const hasUpper = /[A-Z]/.test(password);
      const hasSpecial = /[!@#$%¨&*]/.test(password);
      const hasMinLength = password.length >= 8;

      updateRequirementStyle(number, hasNumber);
      updateRequirementStyle(lower, hasLower);
      updateRequirementStyle(upper, hasUpper);
      updateRequirementStyle(character, hasSpecial);
      updateRequirementStyle(qtdCharacter, hasMinLength);
    }

    function updateRequirementStyle(element, isValid) {
      element.style.color = isValid ? "green" : "#a9a6a6";
      element.style.fontWeight = isValid ? "bold" : "normal";
    }

    function checkPasswordMatch() {
      const password = passwordInput.value;
      const confirm = confirmPasswordInput.value;

      if (confirm === "") {
        divMessage.classList.add("d-none");
        divMessage.innerText = "";
        return;
      }

      if (confirm === password) {
        divMessage.classList.remove("d-none");
        divMessage.innerText = "Senhas conferem!";
        divMessage.style.color = "green";
      } else {
        divMessage.classList.remove("d-none");
        divMessage.innerText = "Senhas não conferem.";
        divMessage.style.color = "red";
      }
    }

    passwordInput.addEventListener("input", () => {
      validatePasswordStrength(passwordInput.value);
      checkPasswordMatch();
    });

    confirmPasswordInput.addEventListener("input", checkPasswordMatch);

    // Função existente para mostrar/ocultar senha
    function change(id) {
      const input = document.getElementById(id);
      if (input.type === "password") {
        input.type = "text";
      } else {
        input.type = "password";
      }
    }
  </script>
@endsection
