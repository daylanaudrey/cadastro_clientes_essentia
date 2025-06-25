<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="container py-4">

    <h2>Clientes</h2>
    <a href="index.php?action=create" class="btn btn-success mb-3">Novo Cliente</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clientes as $c): ?>
                <tr>
                    <td>
                        <?php if($c['foto']): ?>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#imagemModal<?= $c['id'] ?>">
                                <img src="uploads/<?= $c['foto'] ?>" width="60">
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="imagemModal<?= $c['id'] ?>" tabindex="-1" aria-labelledby="imagemModalLabel<?= $c['id'] ?>" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="imagemModalLabel<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                  </div>
                                  <div class="modal-body text-center">
                                    <img src="uploads/<?= $c['foto'] ?>" class="img-fluid">
                                  </div>
                                </div>
                              </div>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($c['nome']) ?></td>
                    <td><?= htmlspecialchars($c['email']) ?></td>
                    <td><?= htmlspecialchars($c['telefone']) ?></td>
                    <td>
                        <a href="index.php?action=edit&id=<?= $c['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="index.php?action=delete&id=<?= $c['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>