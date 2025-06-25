<?php
require_once __DIR__ . '/../config.php';

class Cliente {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function listarPaginado($limite, $offset, $busca = '') {
        $sql = "SELECT * FROM clientes";
        $params = [];

        if (!empty($busca)) {
            $sql .= " WHERE nome LIKE :busca OR email LIKE :busca OR telefone LIKE :busca";
            $params[':busca'] = '%' . $busca . '%';
        }

        $sql .= " ORDER BY nome ASC LIMIT :limite OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contar($busca = '') {
        $sql = "SELECT COUNT(*) as total FROM clientes";
        $params = [];

        if (!empty($busca)) {
            $sql .= " WHERE nome LIKE :busca OR email LIKE :busca OR telefone LIKE :busca";
            $params[':busca'] = '%' . $busca . '%';
        }

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function existeEmail($email, $ignorarId = null) {
        $sql = "SELECT COUNT(*) FROM clientes WHERE email = ?";
        $params = [$email];

        if ($ignorarId !== null) {
            $sql .= " AND id != ?";
            $params[] = $ignorarId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }

    public function inserir($nome, $email, $telefone, $foto) {
        // Remove todos os caracteres não numéricos do telefone
        $telefone = preg_replace('/\D+/', '', $telefone);
        $sql = "INSERT INTO clientes (nome, email, telefone, foto) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $email, $telefone, $foto]);
    }

    public function buscar($id) {
        $sql = $this->pdo->prepare("SELECT * FROM clientes WHERE id = ?");
        $sql->execute([$id]);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id, $nome, $email, $telefone, $foto) {
        // Remove todos os caracteres não numéricos do telefone
        $telefone = preg_replace('/\D+/', '', $telefone);
        $sql = "UPDATE clientes SET nome=?, email=?, telefone=?, foto=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $email, $telefone, $foto, $id]);
    }

    public function excluir($id) {
        $sql = $this->pdo->prepare("DELETE FROM clientes WHERE id = ?");
        return $sql->execute([$id]);
    }
}
?>