$(document).ready(function(){
    $("#cadastrar_ativo").click(function(){
      let descricao_ativo = $("#descricao").val();
      let tipo = $("#tipo").val();
      let marca = $("#marca").val();
      let quantidade = $("#quantidade").val();
      let observacao = $("#obs").val();
      $.ajax({
        type:"POST",
        url: "../controller/ativoController.php",
        data:{
            ativo: descricao_ativo,
            marca: marca,
            tipo: tipo,
            quantidade: quantidade,
            observacao: observacao
        },
        success: function(result){
            alert(result);
            // location.reload();
      }});
    });



 
    // Abrir modal para edição
    $('.editAtivo').on('click', function () {
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
                if (response.success) {
                    location.reload(); // Recarregar a página para atualizar a tabela
                } else {
                    alert('Erro ao salvar os dados: ' + response.error);
                }
            },
            error: function () {
                alert('Erro na comunicação com o servidor.');
            }
        });
    });
});
