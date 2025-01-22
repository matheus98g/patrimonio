$(document).ready(function () {
    // Captura o clique no botão de cadastrar ativo
    $("#cadastrar_ativo").click(function () {
        // Pegando os valores dos campos
        let descricao_ativo = $("#descricao").val();
        let marca = $("#marca").val();
        let tipo = $("#tipo").val();
        let quantidade = $("#quantidade").val();
        let observacao = $("#obs").val();

        // Exibe um alerta caso algum campo obrigatório esteja vazio
        if (!descricao_ativo || !marca || !tipo || !quantidade) {
            alert("Por favor, preencha todos os campos obrigatórios.");
            return;
        }

        // Adicionando log para garantir que os dados estão sendo capturados corretamente
        console.log("Dados para envio:");
        console.log({
            descricao_ativo: descricao_ativo,
            marca: marca,
            tipo: tipo,
            quantidade: quantidade,
            observacao: observacao
        });

        // Envia a requisição AJAX para o controlador
        $.ajax({
            type: "POST",
            url: "../controller/ativoController.php", // Certifique-se de que a URL está correta
            data: {
                action: 'cadastrarAtivo',  // Ação que o controlador deve executar
                ativo: descricao_ativo,   // Passa o valor da descrição do ativo
                marca: marca,             // ID da marca selecionada
                tipo: tipo,               // ID do tipo selecionado
                quantidade: quantidade,   // Quantidade
                observacao: observacao    // Observação (opcional)
            },
            success: function (response) {
                try {
                    // Decodifica a resposta JSON
                    let result = JSON.parse(response);  

                    // Exibe a mensagem de sucesso ou erro retornada pelo controlador
                    alert(result.message);

                    // Se o cadastro for bem-sucedido, recarrega a página
                    if (result.success) {
                        location.reload();
                    }
                } catch (e) {
                    // Erro ao processar a resposta do servidor
                    alert("Erro inesperado ao processar a resposta do servidor.");
                    console.error(e);
                }
            },
            error: function (xhr, status, error) {
                // Log de erro para ajudar a identificar a causa do problema
                console.error("Erro AJAX:", status, error);
                alert("Erro ao enviar a solicitação. Verifique sua conexão e tente novamente.");
            }
        });
    });
});


    // Abrir modal para edição
    $(document).on('click', '.editAtivo', function () {
        const id = $(this).data('id');
        const descricao = $(this).data('descricao');
        const quantidade = $(this).data('quantidade');
        const observacao = $(this).data('observacao');

        // Preencher os campos do modal
        $('#idAtivo').val(id);
        $('#descricaoAtivo').val(descricao);
        $('#qtdAtivo').val(quantidade);
        $('#obsAtivo').val(observacao);

        // Alterar o título do modal
        $('#exampleModalLabel').text('Editar Ativo');

        // Mostrar o modal
        $('#exampleModal').modal('show');
    });

    // Resetar o formulário ao fechar o modal
    $('#exampleModal').on('hidden.bs.modal', function () {
        $('#formAtivo')[0].reset();
        $('#idAtivo').val('');
        $('#exampleModalLabel').text('Cadastrar Ativo');
    });

    // Submeter o formulário via AJAX
    $('#formAtivo').on('submit', function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.ajax({
            url: '../controller/editAtivoController.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                try {
                    let result = JSON.parse(response);

                    if (result.success) {
                        alert(result.message);
                        location.reload(); // Recarregar a página para atualizar a tabela
                    } else {
                        alert('Erro ao salvar os dados: ' + result.error);
                    }
                } catch (e) {
                    alert("Erro inesperado ao processar a resposta do servidor.");
                    console.error(e);
                }
            },
            error: function () {
                alert('Erro na comunicação com o servidor.');
            }
        });
    });

