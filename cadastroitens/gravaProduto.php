<?php

$ncm = $_POST['cNcm'];
$ecoflow_sku = $_POST['cEcoflow_sku'];
$name = $_POST['cName'];
$cost_cents = $_POST['cCost_cents'];
$price_cents = $_POST['cPrice_cents'];
$price_on_time_cents = $_POST['cPrice_on_time_cents'];
$created_at = $_POST['cCreated_at'];
$updated_at = $_POST['cUpdated_at'];

$imagem = $_FILES['cImagem'] ?? null;

include "conecta.php";

// --- CONFIG SUPABASE ---

$supabase_url = 'https://zxrwexyelatcjkmfzqxl.supabase.co';
$supabase_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inp4cndleHllbGF0Y2prbWZ6cXhsIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc2MTU1MDAyOSwiZXhwIjoyMDc3MTI2MDI5fQ.IFlr3a2ASDDdjpz0RgXIMG0Xu_8OnXJ0celL3BLjtrs'; // Use variável de ambiente
$bucket = 'imagens';

// Validação de imagem
$extensao = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
$tipo_mime = mime_content_type($imagem['tmp_name']);
$extensoes_permitidas = ['jpg','jpeg','png','gif'];

if (!in_array($extensao, $extensoes_permitidas)) die("❌ Extensão de arquivo não permitida.");
if ($imagem['size'] > 2 * 1024 * 1024) die("❌ Arquivo muito grande (máx 2MB).");

// Nome do arquivo (mesmo nome para substituir)
$nome_arquivo = "produto_" . $id . "." . $extensao;

// Envia para Supabase usando cURL
if (!function_exists('curl_init')) die("❌ cURL não habilitado.");

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "$supabase_url/storage/v1/object/$bucket/$nome_arquivo",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => file_get_contents($imagem['tmp_name']),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $supabase_key",
        "Content-Type: $tipo_mime",
        "x-upsert: true" // Substitui se já existir
    ],
]);

$response = curl_exec($curl);
$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$error = curl_error($curl);
curl_close($curl);

if ($http_code != 200 && $http_code != 201) {
    die("❌ Erro ao enviar imagem (HTTP $http_code): $error <br>Resposta: $response");
}

// URL pública (permanece a mesma)
$imagem_url = "$supabase_url/storage/v1/object/public/$bucket/$nome_arquivo";

echo "✅ Imagem substituída com sucesso! <br>";
echo "URL pública: <a href='$imagem_url' target='_blank'>$imagem_url</a>";

// --- SALVA NO MYSQL ---
$stmt = $conexao->prepare("INSERT INTO TBPRODUTO 
    (ncm, ecoflow_sku, name, cost_cents, price_cents, price_on_time_cents, created_at, updated_at, imagem) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "sssiissss",
    $ncm,
    $ecoflow_sku,
    $name,
    $cost_cents,
    $price_cents,
    $price_on_time_cents,
    $created_at,
    $updated_at,
    $imagem_url
);

if ($stmt->execute()) {
    echo "✅ GRAVAÇÃO EXECUTADA COM SUCESSO!<br>";
    echo '<meta http-equiv="refresh" content="0;URL=consultaProduto.php">';
} else {
    echo "❌ Erro ao salvar no banco: " . $stmt->error;
}

$stmt->close();
$conexao->close();
?>
