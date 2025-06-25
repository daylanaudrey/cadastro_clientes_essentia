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
        $pagina = $_GET['pagina'] ?? 1;
        $limite = $_GET['limite'] ?? 5;
        $busca = $_GET['busca'] ?? '';
        $offset = ($pagina - 1) * $limite;

        $clientes = $this->cliente->listarPaginado($limite, $offset, $busca);
        $total = $this->cliente->contar($busca);
        $paginas = ceil($total / $limite);

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

        if ($this->cliente->existeEmail($email)) {
            echo "<script>alert('E-mail já cadastrado!'); location.href='index.php?action=create';</script>";
            exit;
        }

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

        if ($this->cliente->existeEmail($email, $id)) {
            echo "<script>alert('E-mail já cadastrado para outro cliente!'); location.href='index.php?action=edit&id=$id';</script>";
            exit;
        }

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