$(document).ready(function () {
    // Função para tratar erro de AJAX
    function handleAjaxError() {
        alert('Erro na comunicação com o servidor.');
    }

    // Função para enviar requisições AJAX
    function sendAjaxRequest(url, data, successCallback) {
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: successCallback,
            error: handleAjaxError
        });
    }

    // Função para validar a senha
    function validatePassword() {
        let password = $("#password").val();
        let confirmPassword = $("#confirm_password").val();
        let passwordMessage = $("#password-error-message");
        let confirmMessage = $("#error-message");

        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&,.])[A-Za-z\d@$!%*?&,.]{8,}$/;

        if (!passwordRegex.test(password)) {
            passwordMessage.text("A senha deve ter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.");
            $("#password").addClass("is-invalid");
            return false;
        } else {
            passwordMessage.text("");
            $("#password").removeClass("is-invalid").addClass("is-valid");
        }

        if (password !== confirmPassword) {
            confirmMessage.text("Senhas não conferem!");
            $("#confirm_password").addClass("is-invalid");
            return false;
        } else {
            confirmMessage.text("");
            $("#confirm_password").removeClass("is-invalid").addClass("is-valid");
            return true;
        }
    }

    // Cadastrar Usuário
    $("#cadastrarUsuario").on("click", function () {
        if (!validatePassword()) return;

        const formData = {
            nome: $("#nomeUsuario").val(),
            email: $("#emailUsuario").val(),
            turma: $("#turmaUsuario").val(),
            senha: $("#password").val()
        };

        sendAjaxRequest("../controller/userController.php", formData, function (response) {
            try {
                const result = JSON.parse(response);
                if (result.success) {
                    alert("Usuário cadastrado com sucesso!");
                    $("#cadastrarUsuarioModal").modal("hide");
                    location.reload();
                } else {
                    alert("Erro: " + result.message);
                }
            } catch (e) {
                alert("Erro ao processar a resposta do servidor.");
                console.error(e);
            }
        });
    });

    // Abrir modal de edição de usuário
    $("#editUserModal").on("show.bs.modal", function (event) {
        const button = $(event.relatedTarget);
        $("#modal-id").val(button.data("id"));
        $("#modal-nome").val(button.data("nome"));
        $("#modal-email").val(button.data("email"));
        $("#modal-turma").val(button.data("turma"));
    });

    // Atualizar usuário
    $("#editarUsuario").on("click", function () {
        const formData = {
            action: "editarUsuario",
            idUsuario: $("#modal-id").val(),
            nomeUsuario: $("#modal-nome").val(),
            emailUsuario: $("#modal-email").val(),
            turmaUsuario: $("#modal-turma").val()
        };

        if (!formData.nomeUsuario.trim() || !formData.emailUsuario.trim() || !formData.turmaUsuario.trim()) {
            alert("Por favor, preencha todos os campos!");
            return;
        }

        sendAjaxRequest("../controller/userController.php", formData, function (response) {
            const data = JSON.parse(response);
            if (data.success) {
                alert("Usuário atualizado com sucesso!");
                location.reload();
            } else {
                alert("Erro ao atualizar o usuário.");
            }
        });
    });

    // Alteração de status do usuário
    $(".btn-alterar-status").change(function () {
        const $this = $(this);
        const idUsuario = $this.data("id");
        const statusUsuario = $this.prop("checked") ? "1" : "0";

        sendAjaxRequest("../controller/userController.php", {
            action: "atualizarStatusUsuario",
            idUsuario: idUsuario,
            statusUsuario: statusUsuario
        }, function (response) {
            const data = JSON.parse(response);
            if (data.success) {
                alert("Status do usuário atualizado com sucesso!");
            } else {
                alert("Erro ao atualizar o status do usuário.");
                $this.prop("checked", !$this.prop("checked"));
            }
        });
    });
});
