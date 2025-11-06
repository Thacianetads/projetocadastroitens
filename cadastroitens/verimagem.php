<?php
include "conecta.php";

if (!isset($_GET['id'])) {
    http_response_code(400);
    exit("ID não informado");
}

$id = intval($_GET['id']);
$sql = "SELECT imagem FROM TBPRODUTO WHERE id = $id";
$rs = mysqli_query($conexao, $sql);

if ($reg = mysqli_fetch_assoc($rs)) {
    if (!empty($reg['imagem'])) {
        // Redireciona para a URL da imagem no Supabase
        header("Location: " . $reg['imagem']);
        exit;
    }
}

http_response_code(404);
echo "Imagem não encontrada";
?>
