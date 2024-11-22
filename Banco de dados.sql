create database pratica;

use pratica;

-- Tabela Clientes
CREATE TABLE Clientes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(150) NOT NULL UNIQUE,
    Telefone VARCHAR(15) NOT NULL
);

INSERT INTO Clientes (Nome, Email, Telefone) 
VALUES ('João Silva', 'joao@gmail.com', '123456789');


-- Tabela Colaboradores
CREATE TABLE Colaboradores (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(150) NOT NULL UNIQUE,
    Cargo VARCHAR(50) NOT NULL
);


INSERT INTO Colaboradores (Nome, Email, Cargo)
VALUES ('João Silva', 'joao.silva@gmail.com', 'Técnico de Suporte');




-- Tabela Chamados
CREATE TABLE Chamados (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    ID_Cliente INT NOT NULL,
    ID_Colaborador INT DEFAULT NULL,
    Descricao TEXT NOT NULL,
    Criticidade ENUM('baixa', 'média', 'alta') NOT NULL,
    Status ENUM('aberto', 'em andamento', 'resolvido') DEFAULT 'aberto',
    Data_Abertura DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Cliente) REFERENCES Clientes(ID),
    FOREIGN KEY (ID_Colaborador) REFERENCES Colaboradores(ID)
    
);

INSERT INTO Chamados (ID_Cliente, ID_Colaborador, Descricao, Criticidade, Status)
VALUES (1, 1, 'Erro ao acessar o sistema.', 'média', 'aberto');


SELECT * FROM Chamados;
