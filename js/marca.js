
$(document).ready(function () {
    $("#cadastrar_marca").click(function () {
        let descricaoMarca = $("#descricao_marca").val();  // Obtém o valor do campo de entrada
        alert('marcaaaaaaaa')

        // Envia a requisição AJAX para o controlador
        $.ajax({
            type: "POST",
            url: "../controller/ativoController.php",
            data: {
                action: 'cadastrarMarca',  // Indica a ação que o controlador deve executar
                marca: descricaoMarca      // Passa o valor da marca
            },
            success: function (response) {
               alert('marcaaaaaaaa')
                let result = JSON.parse(response);  // Decodifica a resposta JSON
                alert(result.message);  // Exibe a mensagem retornada

                // Se o cadastro for bem-sucedido, recarrega a página
                // if (result.success) {
                //     // location.reload();
                // }
            },
            error: function () {
                alert('Erro ao processar a solicitação.');
            }
        });
    });
});










// // $(document).ready(function(){
// //     $("#cadastrar_marca").click(function(){
// //       let descricao_marca = $("#descricao_marca").val();

// //       $.ajax({
// //         type:"POST",
// //         url: "../controller/ativoController.php",
// //         data:{
// //             marca: descricao_marca
// //         },
// //         success: function(result){
// //             alert(result);
// //             location.reload();
// //       }});
// //     });
// //   });


// $(document).ready(function () {
//     $("#cadastrar_marca").click(function () {
//         let descricao_marca = $("#descricao_marca").val();

//         // Validação de campo vazio
//         if (descricao_marca.trim() === "") {
//             alert("Por favor, preencha o campo de descrição da marca.");
//             return;
//         }

//         $.ajax({
//             type: "POST",
//             url: "../controller/ativoController.php",
//             data: {
//                 action: "cadastrarMarca", // Especifica a ação para o controlador
//                 marca: descricao_marca
//             },
//             dataType: "json", // Define o tipo de dado esperado da resposta
//             success: function (response) {
//                 if (response.success) {
//                     alert(response.message); // Exibe mensagem de sucesso
//                     location.reload(); // Recarrega a página para atualizar a lista
//                 } else {
//                     alert(response.message); // Exibe mensagem de erro
//                 }
//             },
//             error: function () {
//                 alert("Erro ao enviar a solicitação. Tente novamente.");
//             }
//         });
//     });
// });
