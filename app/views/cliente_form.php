<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= isset($cliente) ? 'Editar' : 'Novo' ?> Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body class="container py-4">

<h2><?= isset($cliente) ? 'Editar' : 'Novo' ?> Cliente</h2>

<form method="post" enctype="multipart/form-data"
      action="index.php?action=<?= isset($cliente) ? 'update' : 'store' ?>">
    <?php if (isset($cliente)): ?>
        <input type="hidden" name="id" value="<?= $cliente['id'] ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" required
               value="<?= $cliente['nome'] ?? '' ?>">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" id="email" class="form-control" required
               value="<?= $cliente['email'] ?? '' ?>">
    </div>

    <div class="mb-3">
        <label>Telefone</label>
        <input type="text" name="telefone" id="telefone" class="form-control" required
               value="<?= $cliente['telefone'] ?? '' ?>">
    </div>

    <div class="mb-3">
        <label>Foto</label>
        <input type="file" name="foto" id="foto" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        <?php if (!empty($cliente['foto'])): ?>
            <img src="uploads/<?= $cliente['foto'] ?>" width="100" class="mt-2">
        <?php endif; ?>
    </div>

    <button class="btn btn-primary" type="submit">Salvar</button>
    <a href="index.php" class="btn btn-secondary">Voltar</a>
</form>

</body>
<script>
    $(document).ready(function () {
        //Coloca o foco no nome ao iniciar
        $('#nome').focus();

        // Aplica a máscara de telefone
        $('#telefone').mask('(00) 00000-0000');
    });
</script>
</html>