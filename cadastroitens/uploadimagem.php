<?php
include "conecta.php";

// ----- Configurações Supabase -----
$supabaseUrl = ""; // Sua URL
$bucket = "imagens"; // Bucket do Supabase Storage
$apiKey = "<YOUR_SUPABASE_API_KEY>"; // Service key

// Recebe ID do produto
$txtConteudo = filter_input_array(INPUT_POST,FILTER_DEFAULT);
if(!isset($txtConteudo["cId"])){
    echo "ID do produto não informado";
    exit;
}
$id = intval($txtConteudo["cId"]);

// Verifica upload
if(isset($_FILES['cImagem']) && $_FILES['cImagem']['error'] === UPLOAD_ERR_OK){
    $fileTmpPath = $_FILES['cImagem']['tmp_name'];
    $fileName = $_FILES['cImagem']['name'];
    $fileType = $_FILES['cImagem']['type'];

    $uniqueFileName = uniqid() . "_" . $fileName;

    // ----- Upload para Supabase -----
    $uploadUrl = $supabaseUrl . "/storage/v1/object/" . $bucket . "/" . $uniqueFileName;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uploadUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiKey",
        "apikey: $apiKey",
        "Content-Type: $fileType",
        "x-upsert: true"
    ]);
    curl_setopt($ch, CURLOPT_PUT, true);
    curl_setopt($ch, CURLOPT_INFILE, fopen($fileTmpPath, 'rb'));
    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($fileTmpPath));

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if($httpcode == 200 || $httpcode == 201){
        $imagemUrl = $supabaseUrl . "/storage/v1/object/public/$bucket/$uniqueFileName";

        // ----- Atualiza MySQL -----
        $stmt = $conexao->prepare("UPDATE TBPRODUTO SET imagem = ? WHERE ID = ?");
        $stmt->bind_param("si", $imagemUrl, $id);

        if($stmt->execute()){
            echo "Imagem atualizada com sucesso!";
            echo '<meta http-equiv="refresh" content="2;URL=alteraimagem.php?id='.$id.'">';
        } else {
            echo "Erro ao atualizar banco: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro no upload Supabase (HTTP $httpcode): $response";
    }

} else {
    echo "Nenhum arquivo enviado ou ocorreu erro no upload.";
}

mysqli_close($conexao);
?>
