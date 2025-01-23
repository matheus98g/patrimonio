$(document).ready(function () {
    // Adicionar Tipo
    $('#cadastrarTipo').on('click', function () {
        var descricao = $('#descricaoTipo').val();
        
        if (descricao === "") {
            alert("Por favor, preencha a descrição.");
            return;
        }

        $.ajax({
            url: '../controller/ativoController.php',
            type: 'POST',
            data: {
                action: 'cadastrarTipo',
                descricaoTipo: descricao
            },
            success: function (response) {
                try {
                    let result = JSON.parse(response);
                    if (result.success) {
                        alert('Tipo cadastrado com sucesso!');
                        $('#cadastrarTipoModal').modal('hide');
                        location.reload(); // Atualiza a página para mostrar o novo tipo
                    } else {
                        alert('Erro: ' + result.message);
                    }
                } catch (e) {
                    alert('Erro ao processar a resposta do servidor.');
                    console.error(e);
                }
            },
            error: function (xhr, status, error) {
                alert('Erro ao conectar ao servidor.');
                console.error("Erro AJAX:", status, error);
            }
        });
    });

    // Editar Tipo - Abrir modal com os dados
    $('#editTipoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var idTipo = button.data('id');
        var descricao = button.data('descricao');

        $('#editIdTipo').val(idTipo);
        $('#editDescricao').val(descricao);
    });

    // Salvar Edição de Tipo
    $('#saveEditTipo').on('click', function () {
        var idTipo = $('#editIdTipo').val();
        var descricao = $('#editDescricao').val();

        if (descricao === "") {
            alert("Por favor, preencha a descrição.");
            return;
        }

        $.ajax({
            url: '../controller/ativoController.php',
            type: 'POST',
            data: {
                action: 'editarTipo',
                idTipo: idTipo,
                descricaoTipo: descricao
            },
            success: function (response) {
                try {
                    let result = JSON.parse(response);
                    if (result.success) {
                        alert('Tipo atualizado com sucesso!');
                        $('#editTipoModal').modal('hide');
                        location.reload(); // Atualiza a página para refletir as mudanças
                    } else {
                        alert('Erro: ' + result.message);
                    }
                } catch (e) {
                    alert('Erro ao processar a resposta do servidor.');
                    console.error(e);
                }
            },
            error: function (xhr, status, error) {
                alert('Erro ao conectar ao servidor.');
                console.error("Erro AJAX:", status, error);
            }
        });
    });

    $(document).ready(function () {
    // Atualizar status do tipo
    $('.btn-alterar-status').on('change', function () {
        var tipoId = $(this).data('id');
        var status = $(this).is(':checked') ? '1' : '0';

        $.ajax({
            url: '../controller/ativoController.php', // Altere para o seu controller de tipos
            type: 'POST',
            data: {
                action: 'atualizarStatusTipo',
                idTipo: tipoId,
                statusTipo: status
            },
            success: function (response) {
                try {
                    let result = JSON.parse(response);
                    if (result.success) {
                        alert('Status atualizado com sucesso!');
                    } else {
                        alert('Erro ao atualizar status: ' + result.message);
                    }
                } catch (e) {
                    alert('Erro ao processar a resposta do servidor.');
                    console.error(e);
                }
            },
            error: function (xhr, status, error) {
                alert('Erro ao conectar ao servidor.');
                console.error("Erro AJAX:", status, error);
            }
        });
    });
});

});
