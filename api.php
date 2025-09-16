<?php
declare(strict_types=1);
session_start();
header('Content-Type: application/json; charset=utf-8');

// ================== CONFIG BANCO ==================
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'usbw';
$DB_NAME = 'didaxie';

$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
    echo json_encode(['ok' => false, 'error' => 'Erro ao conectar no banco']);
    exit;
}
$mysqli->set_charset('utf8mb4');

// ================== HELPERS ==================
function json_response($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function require_login() {
    if (empty($_SESSION['professor_id'])) {
        json_response(['ok' => false, 'error' => 'Não autenticado']);
    }
    return (int)$_SESSION['professor_id'];
}

// ================== ROTAS ==================
$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {

    switch ($action) {

        case 'me':
            $pid = require_login();
            json_response([
                'ok' => true,
                'me' => [
                    'id' => $pid,
                    'nome' => $_SESSION['professor_nome'] ?? 'Professor',
                    'email' => $_SESSION['professor_email'] ?? 'professor@email.com',
                    'avatar' => ''
                ]
            ]);
            break;

        case 'dashboard_stats':
            $pid = require_login();

            // Função segura para contar registros
            function safe_count($mysqli, $sql) {
                $res = $mysqli->query($sql);
                if ($res) {
                    $row = $res->fetch_assoc();
                    return (int)($row['c'] ?? 0);
                }
                return 0;
            }

            $stats = [
                'totalTurmas' => safe_count($mysqli, "SELECT COUNT(*) c FROM turmas WHERE professor_id=$pid"),
                'totalAlunos' => safe_count($mysqli, "SELECT COUNT(*) c FROM alunos a 
                    JOIN turmas t ON a.turma_id=t.id WHERE t.professor_id=$pid"),
                'totalQuizzes' => safe_count($mysqli, "SELECT COUNT(*) c FROM quizzes WHERE professor_id=$pid"),
                'mediaAproveitamento' => rand(50, 90)
            ];

            json_response(['ok' => true, 'stats' => $stats]);
            break;

        case 'list_turmas':
            $pid = require_login();
            $q = trim($_GET['q'] ?? '');
            $status = trim($_GET['status'] ?? '');
            $sql = "SELECT t.*, (SELECT COUNT(*) FROM alunos a WHERE a.turma_id=t.id) AS alunos 
                    FROM turmas t WHERE t.professor_id=$pid";
            if ($status !== '') $sql .= " AND t.status='" . $mysqli->real_escape_string($status) . "'";
            if ($q !== '') {
                $qEsc = $mysqli->real_escape_string("%$q%");
                $sql .= " AND (t.nome LIKE '$qEsc' OR t.codigo LIKE '$qEsc')";
            }
            $sql .= " ORDER BY t.id DESC";

            $res = $mysqli->query($sql);
            $turmas = [];
            if ($res) while ($row = $res->fetch_assoc()) $turmas[] = $row;

            json_response(['ok' => true, 'turmas' => $turmas]);
            break;

        case 'create_turma':
            $pid = require_login();
            $nome = trim($_POST['nome'] ?? '');
            $serie = trim($_POST['serie'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $limite = (int)($_POST['limite'] ?? 50);
            if ($nome === '' || $serie === '') json_response(['ok' => false, 'error' => 'Preencha nome e série']);

            $codigo = strtoupper(substr(md5(uniqid()), 0, 6));
            $stmt = $mysqli->prepare("INSERT INTO turmas (nome,serie,codigo,status,descricao,limite,professor_id,criado_em) VALUES (?,?,?,?,?,?,?,NOW())");
            $status = 'ativa';
            if ($stmt) {
                $stmt->bind_param("sssssis", $nome, $serie, $codigo, $status, $descricao, $limite, $pid);
                $stmt->execute();
                $id = $stmt->insert_id;
                $stmt->close();
                json_response(['ok' => true, 'turma' => [
                    'id' => $id,
                    'nome' => $nome,
                    'codigo' => $codigo,
                    'serie' => $serie,
                    'status' => 'ativa',
                    'alunos' => 0
                ]]);
            } else {
                json_response(['ok' => false, 'error' => $mysqli->error]);
            }
            break;

        case 'turma_detalhes':
            $pid = require_login();
            $tid = (int)($_GET['turma_id'] ?? 0);
            $res = $mysqli->query("SELECT * FROM turmas WHERE id=$tid AND professor_id=$pid");
            $turma = $res ? $res->fetch_assoc() : null;
            if (!$turma) json_response(['ok' => false, 'error' => 'Turma não encontrada']);

            $alunos = [];
            $res2 = $mysqli->query("SELECT nome,email,0 as xp,1 as nivel,'ativo' as status FROM alunos WHERE turma_id=$tid");
            if ($res2) while ($row = $res2->fetch_assoc()) $alunos[] = $row;

            json_response(['ok' => true, 'turma' => $turma, 'alunos' => $alunos]);
            break;

        case 'list_alunos':
            $pid = require_login();
            $alunos = [];
            $res = $mysqli->query("SELECT a.*,t.nome turma_nome FROM alunos a 
                LEFT JOIN turmas t ON a.turma_id=t.id
                WHERE t.professor_id=$pid
                ORDER BY a.id DESC");
            if ($res) while ($row = $res->fetch_assoc()) $alunos[] = $row;

            $turmas = [];
            $res2 = $mysqli->query("SELECT id,nome FROM turmas WHERE professor_id=$pid");
            if ($res2) while ($r = $res2->fetch_assoc()) $turmas[] = $r;

            json_response(['ok' => true, 'alunos' => $alunos, 'turmas' => $turmas]);
            break;

        case 'create_aluno':
            $pid = require_login();
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = password_hash($_POST['senha'] ?? '123456', PASSWORD_BCRYPT);
            $turma_id = (int)($_POST['turma_id'] ?? 0);
            if ($nome === '' || $email === '') json_response(['ok' => false, 'error' => 'Preencha nome e email']);

            $stmt = $mysqli->prepare("INSERT INTO alunos (nome,usuario,email,senha,turma_id,data_cadastro) VALUES (?,?,?,?,?,NOW())");
            if ($stmt) {
                $usuario = $email;
                $stmt->bind_param("ssssi", $nome, $usuario, $email, $senha, $turma_id);
                $stmt->execute();
                $stmt->close();
                json_response(['ok' => true, 'message' => 'Aluno cadastrado com sucesso!']);
            } else {
                json_response(['ok' => false, 'error' => $mysqli->error]);
            }
            break;

        case 'gerar_quiz':
            if (!isset($_SESSION['professor_id'])) {
                echo json_encode(['ok' => false, 'error' => 'Sessão inválida']);
                exit;
            }

            // Gera código único (6 caracteres alfanuméricos)
            $codigo = strtoupper(substr(md5(uniqid((string)rand(), true)), 0, 6));

            echo json_encode([
                'ok' => true,
                'codigo' => $codigo
            ]);
            break;


        case 'create_quiz':
    $pid = require_login();
    $titulo = trim($_POST['titulo'] ?? '');
    $codigo = trim($_POST['codigo'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');

    if ($titulo === '' || $codigo === '' || $categoria === '') {
        json_response(['ok' => false, 'error' => 'Preencha todos os campos']);
    }

    $stmt = $mysqli->prepare("INSERT INTO quizzes (professor_id, codigo, titulo, categoria, status, criado_em) 
                              VALUES (?, ?, ?, ?, 'publicado', NOW())");
    $stmt->bind_param('isss', $pid, $codigo, $titulo, $categoria);

    if ($stmt->execute()) {
        json_response(['ok' => true, 'id' => $stmt->insert_id]);
    } else {
        json_response(['ok' => false, 'error' => 'Erro ao salvar quiz']);
    }
    break;


        case 'list_quizzes':
            $pid = require_login();
            $quizzes = [];
            $res = $mysqli->query("SELECT id, titulo, categoria, codigo, total_questoes, tentativas, taxa_sucesso, status, criado_em
                                FROM quizzes WHERE professor_id=$pid ORDER BY id DESC");
            if ($res) while ($row = $res->fetch_assoc()) $quizzes[] = $row;
            json_response(['ok' => true, 'quizzes' => $quizzes]);
            break;

        case 'logout':
            session_destroy();
            json_response(['ok' => true, 'message' => 'Logout realizado']);
            break;

        default:
            json_response(['ok' => false, 'error' => 'Ação inválida']);
    }

} catch (Exception $e) {
    json_response(['ok'=>false, 'error'=>$e->getMessage()]);
}


