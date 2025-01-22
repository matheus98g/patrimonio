CREATE TABLE usuario (
    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
    nomeUsuario VARCHAR(100) NOT NULL,
    emailUsuario VARCHAR(100) NOT NULL UNIQUE,
    senhaUsuario VARCHAR(255) NOT NULL,
    turmaUsuario VARCHAR(255) NOT NULL,
    statusUsuario enum('1','0') DEFAULT '1' NOT NULL,
    dataCadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ativo (
    idAtivo INT AUTO_INCREMENT PRIMARY KEY,
    descricaoAtivo VARCHAR(255) NOT NULL,
    qtdAtivo INT NOT NULL,
    statusAtivo TINYINT(1) NOT NULL DEFAULT 1,  -- 1 para ativo, 0 para inativo
    obsAtivo TEXT,  -- Observações sobre o ativo
    idMarca INT NOT NULL,  -- Chave estrangeira para a tabela de marcas
    idTipo INT NOT NULL,  -- Chave estrangeira para a tabela de tipos
    dataCadastro DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Data de criação do registro
    dataAlteracao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  -- Data de última modificação
    idUsuario INT NOT NULL,  -- Chave estrangeira para a tabela de usuários
    FOREIGN KEY (idMarca) REFERENCES marca(idMarca) ON DELETE CASCADE,  -- Relacionamento com a tabela de marcas
    FOREIGN KEY (idTipo) REFERENCES tipo(idTipo) ON DELETE CASCADE,  -- Relacionamento com a tabela de tipos
    FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario) ON DELETE CASCADE  -- Relacionamento com a tabela de usuários
);


CREATE TABLE marca (
    idMarca INT AUTO_INCREMENT PRIMARY KEY,
    descricaoMarca VARCHAR(255) NOT NULL,
    statusMarca CHAR(1) NOT NULL DEFAULT 'S', -- 'S' para ativo, 'N' para inativo
    dataCadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tipo (
    idTipo INT AUTO_INCREMENT PRIMARY KEY,
    descricaoTipo VARCHAR(255) NOT NULL,
    statusTipo CHAR(1) NOT NULL DEFAULT 'S', -- 'S' para ativo, 'N' para inativo
    dataCadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
