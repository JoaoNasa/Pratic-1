<?php
require_once 'bdconnect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_chamado = $_POST['id_chamado'];
    $status = $_POST['status'];
    $id_colaborador = $_POST['id_colaborador'];

    $stmt = $conn->prepare("UPDATE Chamados SET Status = ?, ID_Colaborador = ? WHERE ID = ?");
    $stmt->bind_param("sii", $status, $id_colaborador, $id_chamado);
    $stmt->execute();
    $stmt->close();
}

$filtro_status = $_GET['status'] ?? '';
$query = "SELECT c.ID, cl.Nome AS Cliente, co.Nome AS Colaborador, c.Descricao, c.Criticidade, c.Status 
          FROM Chamados c 
          LEFT JOIN Clientes cl ON c.ID_Cliente = cl.ID 
          LEFT JOIN Colaboradores co ON c.ID_Colaborador = co.ID";
if ($filtro_status) {
    $query .= " WHERE c.Status = '$filtro_status'";
}
$result = $conn->query($query);


$colaboradores = $conn->query("SELECT ID, Nome FROM Colaboradores");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Chamados</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Gerenciamento de Chamados</h1>
        <form action="" method="GET" class="mb-4">
            <label for="status" class="block text-gray-700">Filtrar por Status</label>
            <select id="status" name="status" class="w-full border border-gray-300 rounded p-2">
                <option value="">Todos</option>
                <option value="aberto">Aberto</option>
                <option value="em andamento">Em Andamento</option>
                <option value="resolvido">Resolvido</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Filtrar</button>
        </form>
        <table class="w-full bg-white rounded shadow-md">
            <thead>
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Cliente</th>
                    <th class="border px-4 py-2">Descrição</th>
                    <th class="border px-4 py-2">Criticidade</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Colaborador</th>
                    <th class="border px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td class="border px-4 py-2"><?php echo $row['ID']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['Cliente']; ?></td>
                    <td class="border px-4 py-2"><?php echo $row['Descricao']; ?></td>
                    <td class="border px-4 py-2"><?php echo ucfirst($row['Criticidade']); ?></td>
                    <td class="border px-4 py-2"><?php echo ucfirst($row['Status']); ?></td>
                    <td class="border px-4 py-2"><?php echo $row['Colaborador'] ?? 'Não atribuído'; ?></td>
                    <td class="border px-4 py-2">
                        <form action="" method="POST">
                            <input type="hidden" name="id_chamado" value="<?php echo $row['ID']; ?>">
                            <select name="status" class="border border-gray-300 rounded p-1">
                                <option value="aberto">Aberto</option>
                                <option value="em andamento">Em Andamento</option>
                                <option value="resolvido">Resolvido</option>
                            </select>
                            <select name="id_colaborador" class="border border-gray-300 rounded p-1">
                                <option value="">Nenhum</option>
                                <?php while ($col = $colaboradores->fetch_assoc()): ?>
                                <option value="<?php echo $col['ID']; ?>"><?php echo $col['Nome']; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Atualizar</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
