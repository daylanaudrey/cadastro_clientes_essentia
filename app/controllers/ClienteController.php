<?php
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController
{
    private $cliente;

    public function __construct()
    {
        $this->cliente = new Cliente();
    }

    public function index()
    {
        $clientes = $this->cliente->listar();
        include __DIR__ . '/../views/cliente_list.php';
    }

    public function create()
    {
        include __DIR__ . '/../views/cliente_form.php';
    }

    public function store()
    {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];

        $foto = '';
        if (!empty($_FILES['foto']['name'])) {
            $extensoes_permitidas = ['image/jpeg', 'image/png', 'image/webp'];
            $tipo = mime_content_type($_FILES['foto']['tmp_name']);
            if (in_array($tipo, $extensoes_permitidas)) {
                $foto = uniqid() . '_' . $_FILES['foto']['name'];
                move_uploaded_file(
                    $_FILES['foto']['tmp_name'],
                    __DIR__ . '/../../public/uploads/' . $foto
                );
            }
        }

        $this->cliente->inserir($nome, $email, $telefone, $foto);
        header("Location: index.php");
    }

    public function edit()
    {
        $id = $_GET['id'];
        $cliente = $this->cliente->buscar($id);
        include __DIR__ . '/../views/cliente_form.php';
    }

    public function update()
    {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];

        $clienteAtual = $this->cliente->buscar($id);
        $foto = $clienteAtual['foto'];

        if (!empty($_FILES['foto']['name'])) {
            $extensoes_permitidas = ['image/jpeg', 'image/png', 'image/webp'];
            $tipo = mime_content_type($_FILES['foto']['tmp_name']);
            if (in_array($tipo, $extensoes_permitidas)) {
                $caminhoAntigo = __DIR__ . '/../../public/uploads/' . $foto;
                if (file_exists($caminhoAntigo)) {
                    unlink($caminhoAntigo);
                }
                $foto = uniqid() . '_' . $_FILES['foto']['name'];
                move_uploaded_file(
                    $_FILES['foto']['tmp_name'],
                    __DIR__ . '/../../public/uploads/' . $foto
                );
            }
        }

        $this->cliente->atualizar($id, $nome, $email, $telefone, $foto);
        header("Location: index.php");
    }

    public function delete()
    {
        $id = $_GET['id'];
        $cliente = $this->cliente->buscar($id);

        $caminhoImagem = __DIR__ . '/../../public/uploads/' . $cliente['foto'];
        if (file_exists($caminhoImagem)) {
            unlink($caminhoImagem);
        }

        $this->cliente->excluir($id);
        header("Location: index.php");
    }
}

?>