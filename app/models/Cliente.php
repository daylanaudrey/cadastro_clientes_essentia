<?php
require_once __DIR__ . '/../config.php';

class Cliente {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function listar() {
        $sql = $this->pdo->query("SELECT * FROM clientes ORDER BY id DESC");
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inserir($nome, $email, $telefone, $foto) {
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