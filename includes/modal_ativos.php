<div class="container mt-4">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cadastrar ativo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-1">
                            <label for="descricao" class="col-form-label">Descrição:</label>
                            <input type="text" class="form-control" id="descricao">
                        </div>
                        <div class="mb-1">
                            <label for="marca" class="col-form-label">Marca:</label>
                            <select class="form-select" id="marca">
                                <option value="">Selecione...</option>
                                <?php
                                foreach ($marcas as $marca) {
                                    echo '<option value="' . $marca['idMarca'] . '">' . $marca['descricaoMarca'] . '</option>';
                                };
                                ?>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label for="tipo" class="col-form-label">Tipo:</label>
                            <select class="form-select" id="tipo">
                                <option value="">Selecione...</option>
                                <?php
                                foreach ($tipos as $tipo) {
                                    echo '<option value="' . $tipo['idTipo'] . '">' . $tipo['descricaoTipo'] . '</option>';
                                };
                                ?>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label for="quantidade" class="col-form-label">Quantidade:</label>
                            <input type="number" class="form-control" id="quantidade">
                        </div>
                        <div class="mb-1">
                            <label for="obs" class="col-form-label">Observação:</label>
                            <input type="text" class="form-control" id="obs">
                        </div>
                        <div class="modal-footer p-2">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                            <button type="reset" class="btn btn-secondary">Limpar</button>
                            <button type="submit" class="btn btn-primary" id="cadastrar_ativo">Cadastrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>