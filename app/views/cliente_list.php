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

    <form id="filtroForm" class="d-flex mb-3 gap-2">
        <input type="text" name="busca" id="busca" class="form-control w-50" placeholder="Buscar por nome ou email" value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>">
        <select name="limite" id="limite" class="form-select w-auto">
            <?php foreach ([5,10,25,50] as $val): ?>
                <option value="<?= $val ?>" <?= ($_GET['limite'] ?? 5) == $val ? 'selected' : '' ?>><?= $val ?> por página</option>
            <?php endforeach; ?>
        </select>
    </form>

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
                    <td><?= preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $c['telefone']) ?></td>
                    <td>
                        <a href="index.php?action=edit&id=<?= $c['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                        <a href="index.php?action=delete&id=<?= $c['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    </body>
<script>
  $(function () {
      let controller = new AbortController();

      function carregarResultados() {
          const busca = $('#busca').val();
          const limite = $('#limite').val();

          controller.abort(); // cancela a requisição anterior
          controller = new AbortController();

          fetch(`index.php?action=index&busca=${encodeURIComponent(busca)}&limite=${limite}`, {
              signal: controller.signal
          })
          .then(response => response.text())
          .then(data => {
              const html = $('<div>').html(data);
              const novaTabela = html.find('table');
              const novaPaginacao = html.find('.pagination');

              if (novaTabela.length) {
                  $('table').replaceWith(novaTabela);
                  $('.pagination').remove();
                  if (novaPaginacao.length) {
                      $('table').after(novaPaginacao);
                  }
              } else {
                  $('table tbody').html('<tr><td colspan="5" class="text-center">Nenhum resultado encontrado</td></tr>');
                  $('.pagination').remove();
              }
          })
          .catch(err => {
              if (err.name !== 'AbortError') {
                  console.error('Erro ao carregar resultados:', err);
              }
          });
      }

      $('#busca').on('input', carregarResultados);
      $('#limite').on('change', carregarResultados);
  });
</script>
<?php if (isset($paginas) && $paginas > 1): ?>
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $paginas; $i++): ?>
                <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
                    <a class="page-link" href="index.php?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>
</html>