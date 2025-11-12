<?php

$txtConteudo = filter_input_array(INPUT_POST,FILTER_DEFAULT);

if(isset($txtConteudo["cId"])){
    $id = $txtConteudo["cId"];
    $ncm = $txtConteudo["cNcm"];
    $ecoflow_sku = $txtConteudo["cEcoflow_sku"];
    $name = $txtConteudo["cName"];
    $preco  = $txtConteudo["cPreco"];
    $fabricante = $txtConteudo['cFabricante'];
    $fornecedor = $txtConteudo['cFornecedor'];
    $tags = $txtConteudo['cTags'];
    date_default_timezone_set('America/Sao_Paulo');
    $updated_at = date('Y-m-d H:i:s');

}else{

    echo 'Não foi alterado';
    echo '<meta http-equiv="refresh" content="2;URL=alteraProduto.php" />';
}
include "conecta.php";


$sql = "UPDATE TBPRODUTO SET ";
$sql = $sql." ncm = '$ncm',";
$sql = $sql." ecoflow_sku = '$ecoflow_sku',";
$sql = $sql." name = '$name',";
$sql = $sql." preco = '$preco',";
$sql = $sql." fabricante = '$fabricante',";
$sql = $sql." fornecedor = '$fornecedor',";
$sql = $sql." tags = '$tags',";
$sql = $sql." updated_at = '$updated_at'";


$sql = $sql." WHERE ID = '".$id."'";
echo $sql;
$rs = mysqli_query($conexao,$sql);
if (!$rs){
    echo $sql;
    echo'Problemas na gravação';
    echo'<meta http-equiv="refresh"
        content="10";URL=index.php/>';
        return;
}
mysqli_close($conexao);
echo "<br>GRAVAÇÃO EXECUTADA COM SUCESSO!";
echo'<meta http-equiv="refresh"
        content="0;URL=consultaProduto.php">';
?>
    

