<?php

$ncm = $_POST['cNcm'];
$ecoflow_sku = $_POST['cEcoflow_sku'];
$name = $_POST['cName'];
$preco = $_POST['cPreco'];
$fabricante = $_POST['cFabricante'];
$fornecedor = $_POST['cFornecedor'];
$tags = $_POST['cTags'];
date_default_timezone_set('America/Sao_Paulo');
$created_at = date('Y-m-d H:i:s');
$updated_at = date('Y-m-d H:i:s');
$imagem = $_FILES["cImagem"] ?? null;
$acao = 'cadastrar'; 



if (!$name || !$preco) die("❌ Nome ou preço do produto não informado.");

$imagem_url = null;


if ($imagem && $imagem['error'] === UPLOAD_ERR_OK) {

    $extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
    $tipo_mime = mime_content_type($imagem['tmp_name']);
    $extensoes_permitidas = ['jpg','jpeg','png','gif'];
    $max_size = 2 * 1024 * 1024;

    if (!in_array($extensao, $extensoes_permitidas)) die("❌ Extensão de arquivo não permitida.");
    if ($imagem['size'] > $max_size) die("❌ Arquivo muito grande (máx 2MB).");

    // Gera nome único da imagem
    $nome_arquivo = "produto_" . uniqid() . "." . $extensao;

    $supabase_url = 'https://zxrwexyelatcjkmfzqxl.supabase.co';
    $supabase_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp4cndleHllbGF0Y2prbWZ6cXhsIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc2MTU1MDAyOSwiZXhwIjoyMDc3MTI2MDI5fQ.IFlr3a2ASDDdjpz0RgXIMG0Xu_8OnXJ0celL3BLjtrs'; // Use variável de ambiente
    $bucket = 'imagens';

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "$supabase_url/storage/v1/object/$bucket/$nome_arquivo",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => file_get_contents($imagem['tmp_name']),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $supabase_key",
            "Content-Type: $tipo_mime",
            "x-upsert: true"
        ],
    ]);

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);
    curl_close($curl);

    if ($http_code != 200 && $http_code != 201) die("❌ Erro ao enviar imagem (HTTP $http_code): $error");

    $imagem_url = "$supabase_url/storage/v1/object/public/$bucket/$nome_arquivo";
    echo "✅ Imagem enviada com sucesso! <br>";
}

include "conecta.php";


// --- SALVA NO MYSQL ---
$stmt = $conexao->prepare("INSERT INTO TBPRODUTO 
    (ncm, ecoflow_sku, name, preco, fabricante, fornecedor, tags, created_at, updated_at, imagem) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "sssissssss",
    $ncm,
    $ecoflow_sku,
    $name,
    $preco,
    $fabricante,
    $fornecedor,
    $tags,
    $created_at,
    $updated_at,
    $imagem_url
);

if ($imagem_url) {
    $webhook_url = "https://n8n-cwb-main-webhook-test.nwdrones.com.br/webhook/cadastroproduto";
    $curl_webhook = curl_init();
    curl_setopt_array($curl_webhook, [
        CURLOPT_URL => $webhook_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'acao' => $acao,
            'ncm' => $ncm,
            'sku' => $ecoflow_sku,
            'name' => $name,
            'preco' => $preco,
            'fabricante' => $fabricante,
            'fornecedor' => $fornecedor,
            'tags' => $tags,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'imagem_url' => $imagem_url
        ]),
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
    ]);
    curl_exec($curl_webhook);
    curl_close($curl_webhook);
}


if ($stmt->execute()) {
    echo "✅ GRAVAÇÃO EXECUTADA COM SUCESSO!<br>";
    echo '<meta http-equiv="refresh" content="0;URL=consultaProduto.php">';
} else {
    echo "❌ Erro ao salvar no banco: " . $stmt->error;
}


$stmt->close();
$conexao->close();
?>
