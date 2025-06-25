
DOCUMENTAÇÃO DO SISTEMA DE CADASTRO DE CLIENTES (PHP + jQuery + MVC)

Requisitos
- PHP 7.4+ ou 8.x
- MySQL/MariaDB
- Servidor local: MAMP, XAMPP, WAMP ou LAMP
- Navegador moderno (Chrome, Firefox etc.)

Estrutura de Pastas
clientes/
├── app/
│   ├── config.php              # Conexão com banco de dados
│   ├── controllers/
│   ├── models/
│   └── views/
├── public/
│   ├── uploads/                # Pasta onde as imagens são salvas
│   └── index.php               # Ponto de entrada do sistema

1. Criar o banco de dados

No phpMyAdmin ou via linha de comando MySQL:

CREATE DATABASE cadastro_clientes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cadastro_clientes;

CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  telefone VARCHAR(20) NOT NULL,
  foto VARCHAR(255)
);

2. Configurar conexão com o banco

Abra o arquivo app/config.php e edite conforme seu ambiente:

$host = "localhost";
$db   = "cadastro_clientes";
$user = "root";
$pass = "root"; // ou senha em branco no XAMPP

3. Executar o sistema

Acesse via navegador:
http://localhost/clientes/public/

Use o botão "Novo Cliente" para cadastrar.
As imagens serão exibidas em miniatura e clicáveis.
Pode editar, excluir e a imagem anterior será automaticamente removida do servidor.

4. Uploads de imagem

- As imagens devem ser dos tipos: .jpg, .jpeg, .png, .webp
- São salvas em: public/uploads/
- Validação de extensão feita no front-end (HTML) e no back-end (PHP)
- Ao editar e trocar, a anterior é removida

Funcionalidades

- Cadastro, edição e exclusão de clientes
- Upload de imagem com preview em miniatura
- Máscara e validação de telefone com jQuery
- Padrão MVC simples (Model / View / Controller)
- Interface com Bootstrap 5
