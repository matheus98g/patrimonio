<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAtivo">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastrar Ativo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="idAtivo" name="idAtivo"> <!-- Campo oculto para o ID -->
                    <div class="mb-3">
                        <label for="descricaoAtivo" class="form-label">Descrição</label>
                        <input type="text" class="form-control" id="descricaoAtivo" name="descricaoAtivo" required>
                    </div>
                    <div class="mb-3">
                        <label for="qtdAtivo" class="form-label">Quantidade</label>
                        <input type="number" class="form-control" id="qtdAtivo" name="qtdAtivo" required>
                    </div>
                    <div class="mb-3">
                        <label for="obsAtivo" class="form-label">Observação</label>
                        <textarea class="form-control" id="obsAtivo" name="obsAtivo"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>