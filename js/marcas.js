$(document).ready(function () {
    // Função para tratar erro de AJAX
    function handleAjaxError() {
        alert('Erro na comunicação com o servidor.');
    }

    // Função para enviar requisições AJAX de forma mais eficiente
    function sendAjaxRequest(url, data, successCallback) {
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: successCallback,
            error: handleAjaxError
        });
    }

    // Cadastro de marca
    $("#cadastrar_marca").click(function () {
        let descricaoMarca = $("#descricao_marca").val();

        if (!descricaoMarca.trim()) {
            alert('Por favor, preencha o campo de descrição da marca.');
            return;
        }

        sendAjaxRequest("../controller/ativoController.php", {
            action: 'cadastrarMarca',
            marca: descricaoMarca
        }, function (response) {
            let result = JSON.parse(response);
            alert(result.message); // Exibe a mensagem retornada

            // Se o cadastro for bem-sucedido, recarrega a página
            if (result.success) {
                location.reload();
            }
        });
    });

    // Alteração de status de marca
    $('.btn-alterar-status').change(function () {
        var idMarca = $(this).data('id');  // Obtém o ID da marca
        var statusMarca = $(this).prop('checked') ? '1' : '0';  // Determina o status baseado no checkbox

        var $this = $(this);  // Armazena o contexto do elemento para uso posterior

        sendAjaxRequest('../controller/ativoController.php', {
            action: 'atualizarStatusMarca',  // Ação que será processada no controlador
            idMarca: idMarca,
            statusMarca: statusMarca
        }, function (response) {
            var data = JSON.parse(response);  // Decodifica a resposta JSON
            if (data.success) {
                alert('Status da marca atualizado com sucesso!');
            } else {
                alert('Erro ao atualizar o status da marca.');
                // Reverte o status do checkbox em caso de erro
                $this.prop('checked', !($this.prop('checked')));
            }
        });
    });

    // Ao abrir o modal de edição de marca
    $('#editMarcaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var idMarca = button.data('id');
        var descricaoMarca = button.data('descricao');

        $('#editIdMarca').val(idMarca);
        $('#editDescricaoMarca').val(descricaoMarca);
    });

    // Atualizar marca via modal
    $('#editarMarca').click(function () {
        var idMarca = $('#editIdMarca').val();
        var descricaoMarca = $('#editDescricaoMarca').val();

        if (!descricaoMarca.trim()) {
            alert('Por favor, informe a descrição da marca!');
            return;
        }

        sendAjaxRequest('../controller/ativoController.php', {
            action: 'editarMarca',
            idMarca: idMarca,
            descricaoMarca: descricaoMarca
        }, function (response) {
            var data = JSON.parse(response);
            if (data.success) {
                alert('Marca atualizada com sucesso!');
                location.reload(); // Recarregar a página
            } else {
                alert('Erro ao atualizar a marca.');
            }
        });
    });
});
