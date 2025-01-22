$(document).ready(function () {
    // Função para exibir mensagens ao usuário
    function exibirMensagem(tipo, mensagem) {
        alert(mensagem); // Substitua por um componente de notificação, se desejar
    }

    // Cadastro de ativo
    $("#cadastrar_ativo").click(function () {
        let descricao_ativo = $("#descricao").val();
        let marca = $("#marca").val();
        let tipo = $("#tipo").val();
        let quantidade = $("#quantidade").val();
        let observacao = $("#obs").val();

        if (!descricao_ativo || !marca || !tipo || !quantidade) {
            exibirMensagem('erro', "Preencha todos os campos obrigatórios.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "../controller/ativoController.php",
            data: {
                action: 'cadastrarAtivo',
                ativo: descricao_ativo,
                marca: marca,
                tipo: tipo,
                quantidade: quantidade,
                observacao: observacao
            },
            beforeSend: function () {
                $("#cadastrar_ativo").prop('disabled', true);
            },
            success: function (response) {
                try {
                    let result = JSON.parse(response);
                    exibirMensagem(result.success ? 'sucesso' : 'erro', result.message);
                    if (result.success) location.reload();
                } catch (e) {
                    exibirMensagem('erro', "Erro ao processar a resposta do servidor.");
                    console.error(e);
                }
            },
            error: function () {
                exibirMensagem('erro', "Erro ao enviar a solicitação.");
            },
            complete: function () {
                $("#cadastrar_ativo").prop('disabled', false);
            }
        });
    });

    $(document).on('change', '.btn-alterar-status', function () {
    // Obter os atributos do switch
    let idAtivo = $(this).data('id');
    let statusAtual = $(this).data('status');
    let novoStatus = this.checked ? 1 : 0; // Determina o novo status com base no estado do switch

    console.log('Dados enviados:', {
        idAtivo: idAtivo,
        statusAtual: statusAtual,
        novoStatus: novoStatus
    });

    // Enviar requisição AJAX para atualizar o status
    $.ajax({
        url: '../controller/ativoController.php',
        type: 'POST',
        data: {
            action: 'atualizarStatusAtivo',
            idAtivo: idAtivo,
            statusAtivo: novoStatus
        },
        success: function (response) {
            try {
                let result = JSON.parse(response);
                console.log('Resposta do servidor:', result);

                if (result.success) {
                    alert('Status atualizado com sucesso!');
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

     // Preencher modal de edição
        $(document).on('click', '[data-bs-target="#editAtivoModal"]', function() {
            const button = $(this);
            $('#modal-id').val(button.data('id'));
            $('#modal-descricao').val(button.data('descricao'));
            $('#modal-quantidade').val(button.data('quantidade'));
            $('#modal-observacao').val(button.data('observacao'));
        });
});
