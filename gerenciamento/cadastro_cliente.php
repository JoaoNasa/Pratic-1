<?php
require_once 'bdconnect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "E-mail inválido!";
    } elseif (empty($nome) || empty($telefone)) {
        $mensagem = "Preencha todos os campos obrigatórios!";
    } else {
        $stmt = $conn->prepare("INSERT INTO Clientes (Nome, Email, Telefone) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $telefone);
        if ($stmt->execute()) {
            $mensagem = "Cliente cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar cliente: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Cadastro de Clientes</h1>
        <?php if (isset($mensagem)): ?>
            <div class="bg-<?php echo strpos($mensagem, 'sucesso') ? 'green' : 'red'; ?>-500 text-white p-4 rounded mb-4">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>
        <form action="" method="POST" class="bg-white p-6 shadow-md rounded">
            <div class="mb-4">
                <label for="nome" class="block text-gray-700">Nome</label>
                <input type="text" id="nome" name="nome" class="w-full border border-gray-300 rounded p-2" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">E-mail</label>
                <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded p-2" required>
            </div>
            <div class="mb-4">
                <label for="telefone" class="block text-gray-700">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="w-full border border-gray-300 rounded p-2" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Cadastrar</button>
        </form>
    </div>
</body>
</html>
