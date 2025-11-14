<?php
include "conecta.php";
$txtConteudo = filter_input_array(INPUT_GET,FILTER_DEFAULT);
if (isset($txtConteudo["id"])){
    $varId = $txtConteudo["id"];
    //comando para buscar os dados do id respectivo
    $sql = "SELECT * FROM TBPRODUTO ";
    $sql = $sql."WHERE id = '".$varId."'";

    $rs = mysqli_query($conexao,$sql);
    $reg = mysqli_fetch_array($rs);

    $id = $reg["id"];
    $ncm = $reg ["ncm"];
    $ecoflow_sku = $reg["ecoflow_sku"];
    $name = $reg["name"];
    $preco = $reg["preco"];
    $created_at = $reg["created_at"];
    $updated_at = $reg["updated_at"];
    $fabricante = $reg['fabricante'];
    $fornecedor = $reg['fornecedor'];
    $tags = $reg['tags'];
    $imagem = $reg["imagem"];
    $acao = 'Atualizar item';
    
}else{
    echo "REGISTRO NÃO LOCALIZADO!";
    echo "<meta HTTP-EQUIV='Refresh' CONTENT='5;URL=consultaPessoa.php'>";
}
?>

<html>
<head>
    <title> Alterar dados do produto </title>
<style>
    #drop-area {
    width: 300px;
    height: 200px;
    border: 2px dashed #ccc;
    border-radius: 10px;
    text-align: center;
    line-height: 200px;
    font-family: Arial, sans-serif;
    color: #aaa;
    margin: 50px auto;
    cursor: pointer;
  }
  #drop-area img {
    max-width: 100%;
    max-height: 100%;
    display: block;
    margin: 0 auto;
  }

  /* Fundo geral e estilo base */
body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #dfe9f3 0%, #ffffff 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Caixa principal */
.container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    padding: 30px 40px;
    width: 350px;
}

 .drop-area {
    width: 300px;
    height: 200px;
    border: 2px dashed #ccc;
    border-radius: 10px;
    text-align: center;
    line-height: 200px;
    font-family: Arial, sans-serif;
    color: #aaa;
    margin: 50px auto;
  }
  .drop-area img {
    max-width: 100%;
    max-height: 100%;
    display: block;
    margin: 0 auto;
  }

/* Rótulos e campos */
label {
    display: block;
    margin-top: 10px;
    color: #444;
    font-weight: 600;
}

input[type="text"],
input[type="number"],
input[type="datetime-local"],
input[type="file"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-top: 5px;
    font-size: 14px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

/* Efeito ao focar */
input:focus {
    border-color: #0078d7;
    box-shadow: 0 0 5px rgba(0, 120, 215, 0.4);
    outline: none;
}

/* Botão bonito */
.btn {
    margin-top: 20px;
    width: 100%;
    background-color: #0078d7;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn:hover {
    background-color: #005fa3;
}

.styled-select {
  appearance: none;
  background-color: #ffffff;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 10px 40px 10px 15px; /* reduzido para caber o texto */
  font-size: 16px;
  color: #333;
  cursor: pointer;
  width: 100%; /* garante que ocupe toda a largura do container */
  box-sizing: border-box; /* evita estouro do container */
  background-image: url('data:image/svg+xml;utf8,<svg fill="%23333" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
  background-repeat: no-repeat;
  background-position: right 10px center;
  transition: all 0.3s ease;
}

.styled-select:hover {
  border-color: #888;
}

.styled-select:focus {
  border-color: #0078ff;
  box-shadow: 0 0 4px rgba(0, 120, 255, 0.4);
  outline: none;
}
</style>
</head>
<body>
<div class="container"> 
<h1>TELA PARA ALTERAR DADOS DO PRODUTO </H1> <HR><BR>
<form action="gravaAlteracao.php" id="produtoForm" method="post"> 
<input type="hidden" id="id" name="cId" value="<?php print $id;?>"/>
<label> NCM: </label>
<input type="text" id="ncm" name="cNcm" value="<?php print $ncm;?>" required><br>
<label> SKU: </label>
<input type="text" id="ecoflow_sku" name="cEcoflow_sku" value="<?php print $ecoflow_sku;?>" required><br>
<label> Nome: </label>
<input type="text" id="name" name="cName" value="<?php print $name;?>" required><br>
<label> Preço: </label>
<input type="text" id="preco" name="cPreco" value="<?php print $preco;?>" required><br>
<label>Fabricante:</label>
    <select name="cFabricante" id="fabricante" class="styled-select" required>
    <option value="">Selecione a opção</option>
    <option value="PGYTECH" <?php if ($fabricante == "PGYTECH") echo "selected"; ?>>PGYTECH</option>
    <option value="DJI" <?php if ($fabricante == "DJI") echo "selected"; ?>>DJI</option>
    <option value="ECOFLOW" <?php if ($fabricante == "ECOFLOW") echo "selected"; ?>>ECOFLOW</option>
    <option value="AUTEL" <?php if ($fabricante == "AUTEL") echo "selected"; ?>>AUTEL</option>
    <option value="MICASENSE" <?php if ($fabricante == "MICASENSE") echo "selected"; ?>>MICASENSE</option>
    <option value="SPACEX" <?php if ($fabricante == "SPACEX") echo "selected"; ?>>SPACEX</option>
    </select>
<label>Fornecedor:</label>
        <select name="cFornecedor" id="fornecedor" class="styled-select" required>
        <option value="">Selecione a opção</option>
        <option value="MULTILASER" <?php if ($fornecedor == "MULTILASER") echo "selected"; ?>>MULTILASER</option>
        <option value="INTELBRAS" <?php if ($fornecedor == "INTELBRAS") echo "selected"; ?>>INTELBRAS</option>
        <option value="TIMBER" <?php if ($fornecedor == "TIMBER") echo "selected"; ?>>TIMBER</option>
        <option value="GOLDEN DISTRIBUIDORA LTDA" <?php if ($fornecedor == "GOLDEN DISTRIBUIDORA LTDA") echo "selected"; ?>>GOLDEN DISTRIBUIDORA LTDA</option>
        <option value="GOHOBBYT FUTURE TECHNOLOGY LTDA" <?php if ($fornecedor == "GOHOBBYT FUTURE TECHNOLOGY LTDA") echo "selected"; ?>>GOHOBBYT FUTURE TECHNOLOGY LTDA</option>
        <option value="ALLCOMP" <?php if ($fornecedor == "ALLCOMP") echo "selected"; ?>>ALLCOMP</option>
        <option value="DRONENERDS" <?php if ($fornecedor == "DRONENERDS") echo "selected"; ?>>DRONENERDS</option>
        <option value="SANTIAGO & SINTRA" <?php if ($fornecedor == "SANTIAGO & SINTRA") echo "selected"; ?>>SANTIAGO & SINTRA</option>
        <option value="POWERSAFE" <?php if ($fornecedor == "POWERSAFE") echo "selected"; ?>>POWERSAFE</option>
        <option value="AGEAGLE AERIAL SYSTEMS INC" <?php if ($fornecedor == "AGEAGLE AERIAL SYSTEMS INC") echo "selected"; ?>>AGEAGLE AERIAL SYSTEMS INC</option>
        <option value="STARLINK" <?php if ($fornecedor == "STARLINK") echo "selected"; ?>>STARLINK</option>
        </select>
<label>Tags:</label>
        <select name="cTags" id="tags" class="styled-select" required>
        <option value="">Selecione a opção</option>
        <option value="Agras" <?php if ($tags == "Agras") echo "selected"; ?>>Agras</option>
        <option value="Consumer" <?php if ($tags == "Consumer") echo "selected"; ?>>Consumer</option>
        <option value="DEMO" <?php if ($tags == "DEMO") echo "selected"; ?>>DEMO</option>
        <option value="DN" <?php if ($tags == "DN") echo "selected"; ?>>DN</option>
        <option value="Ecoflow" <?php if ($tags == "Ecoflow") echo "selected"; ?>>Ecoflow</option>
        <option value="Enterprise" <?php if ($tags == "Enterprise") echo "selected"; ?>>Enterprise</option>
        <option value="Pecas" <?php if ($tags == "Pecas") echo "selected"; ?>>Pecas</option>
        <option value="Starlink" <?php if ($tags == "Starlink") echo "selected"; ?>>Starlink</option>
        <option value="Treinamento" <?php if ($tags == "Treinamento") echo "selected"; ?>>Treinamento</option>
        </select>
<br>


<input type="submit" value="Enviar" name="b1" class="btn"><br>
</form>

<form action="adicionaimagem.php" method="post" enctype="multipart/form-data"> 
<input type="hidden" name="cId" value="<?php echo $id;?>"/>
<br>
<br>
<label>Atualizar imagem:</label><br>
<input type="file" name="cImagem" id="imagem" accept="image/*" enctype="multipart/form-data"><br>
<input type="submit" value="Enviar" name="b1" class="btn"><br>
</div>
<br>
<br>

</form>

<script>
    document.getElementById('produtoForm').addEventListener('submit', async (e) => {
  const data = {
    acao: document.getElementById('Atualizar item').value,
    ncm: document.getElementById('ncm').value,
    ecoflow_sku: document.getElementById('ecoflow_sku').value,
    name: document.getElementById('name').value,
    preco: document.getElementById('preco').value,
    fabricante: document.getElementById('fabricante').value,
    fornecedor: document.getElementById('fornecedor').value,
    tags: document.getElementById('tags').value,
    imagem: document.getElementById('imagem').value

  };

  fetch('https://n8n-cwb-main-webhook-test.nwdrones.com.br/webhook/8d52a45b-7e38-4a90-888b-3a89b5c682bf', {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  });
  // não usa preventDefault — o PHP ainda recebe o POST
});

</script>
</div>
</body>
</html>

