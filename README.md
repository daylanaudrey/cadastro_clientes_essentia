Sistema de Cadastro de Clientes - Essentia
==========================================

Este projeto é um pequeno sistema web em PHP puro com padrão MVC, utilizando jQuery, Bootstrap 5 e MySQL, com objetivo de cadastrar e gerenciar clientes. O sistema conta com formulário para inclusão e edição, listagem com miniatura da foto do cliente, filtro dinâmico, paginação com controle de quantidade por página e máscara de telefone.

FUNCIONALIDADES
---------------
- Cadastro de clientes com os campos:
  - Nome
  - E-mail (único)
  - Telefone (apenas números salvos no banco)
  - Foto (com preview e ampliação)
- Edição de clientes
- Exclusão de clientes (com remoção da imagem no servidor)
- Máscara para telefone no formulário (formato: (00) 00000-0000)
- Validação de formato da imagem (jpg, jpeg, png, webp)
- Listagem com:
  - Miniatura clicável da foto
  - Paginação dinâmica
  - Filtro em tempo real por nome, e-mail ou telefone (ignora máscara)
  - Controle da quantidade de registros por página
- Interface responsiva com Bootstrap 5

TECNOLOGIAS
-----------
- PHP 8.x
- MySQL
- jQuery
- Bootstrap 5
- HTML5 + CSS3
- JavaScript (vanilla + jQuery)
- Arquitetura MVC simples

ESTRUTURA DO PROJETO
---------------------
/public
  index.php            # Front controller
  /uploads             # Fotos dos clientes

/app
  /controllers
    ClienteController.php
  /models
    Cliente.php
  /views
    cliente_form.php
    cliente_list.php
  config.php           # Conexão com o banco de dados

/db
  script.sql           # Script de criação da tabela

REQUISITOS
----------
- PHP 8.x (testado com MAMP)
- MySQL
- Servidor local (MAMP, XAMPP, LAMP, etc.)
- Composer (opcional)

INSTALAÇÃO
----------
1. Clone este repositório:
   git clone https://github.com/daylanaudrey/cadastro_clientes_essentia.git

2. Coloque a pasta dentro da sua pasta pública do servidor local (ex: htdocs ou Sites/localhost).

3. Crie o banco de dados:
   - Nome do banco: cadastro_clientes
   - Execute o script SQL abaixo:

SCRIPT SQL
----------
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `telefone` varchar(20) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

4. Ajuste o arquivo app/config.php se necessário com as credenciais do seu MySQL.

5. Acesse via navegador:
   http://localhost/cadastro_clientes_essentia/public/

OBSERVAÇÕES
-----------
- A pasta public/uploads precisa ter permissão de escrita.
- Ao editar a foto, a anterior será removida do servidor.
- E-mails duplicados não são permitidos.
- Telefones são armazenados sem máscara no banco e exibidos com máscara formatada na listagem.

AUTOR
-----
Desenvolvido por Daylan Audrey Gerhardt (https://github.com/daylanaudrey)
