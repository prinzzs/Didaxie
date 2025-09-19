<?php
// criarbanco.php
declare(strict_types=1);

// CONFIG BANCO
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'didaxie';

// Conecta no MySQL (sem selecionar DB ainda)
$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS);
if ($mysqli->connect_error) {
    die("Erro ao conectar no MySQL: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

// Criar banco se não existir
if (!$mysqli->query("CREATE DATABASE IF NOT EXISTS `$DB_NAME` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
    die("Erro ao criar banco: " . $mysqli->error);
}
echo "Banco de dados `$DB_NAME` verificado/criado com sucesso.<br>";

// Seleciona o banco
$mysqli->select_db($DB_NAME);

// SCRIPT SQL para criar tabelas
$sqlScript = <<<SQL
CREATE TABLE IF NOT EXISTS professores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    ano ENUM( '1º Ano Fundamental', '2º Ano Fundamental', '3º Ano Fundamental', '4º Ano Fundamental', '5º Ano Fundamental', '6º Ano Fundamental', '7º Ano Fundamental', '8º Ano Fundamental', '9º Ano Fundamental', '1º Ano Ensino Médio', '2º Ano Ensino Médio', '3º Ano Ensino Médio', 'EJA' ) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    professor_id INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    serie VARCHAR(50),
    descricao TEXT,
    limite INT DEFAULT 50,
    status ENUM('ativa','inativa') DEFAULT 'ativa',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (professor_id) REFERENCES professores(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    turma_id INT NULL,
    nome VARCHAR(100) NOT NULL,
    usuario VARCHAR(100) UNIQUE,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nascimento DATE NULL,
    personagem varchar(20) NOT NULL DEFAULT 'Jett',
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (turma_id) REFERENCES turmas(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    professor_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    codigo VARCHAR(10) UNIQUE NOT NULL,
    categoria VARCHAR(100),
    total_questoes INT DEFAULT 0,
    tentativas INT DEFAULT 0,
    taxa_sucesso FLOAT DEFAULT 0,
    status ENUM('rascunho','publicado') DEFAULT 'rascunho',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (professor_id) REFERENCES professores(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS questoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    enunciado TEXT NOT NULL,
    tipo ENUM('multipla_escolha','verdadeiro_falso') DEFAULT 'multipla_escolha',
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS respostas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    questao_id INT NOT NULL,
    texto VARCHAR(255) NOT NULL,
    correta BOOLEAN DEFAULT 0,
    FOREIGN KEY (questao_id) REFERENCES questoes(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS quiz_participantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quiz_id INT NOT NULL,
    aluno_id INT NOT NULL,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE
);
SQL;

// Executa múltiplos comandos
if ($mysqli->multi_query($sqlScript)) {
    do {
        if ($result = $mysqli->store_result()) {
            $result->free();
        }
    } while ($mysqli->next_result());
    echo "Tabelas criadas/verificadas com sucesso.<br>";
} else {
    die("Erro ao criar tabelas: " . $mysqli->error);
}

echo "<strong>Instalação concluída!</strong>";
