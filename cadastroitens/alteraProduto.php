<?php
include "conecta.php";
$txtConteudo = filter_input_array(INPUT_GET,FILTER_DEFAULT);
if (isset($txtConteudo["id"])){
    $varId = $txtConteudo["id"];
    //comando para buscar os dados do id respectivo
    $sql = "SELECT * FROM TBPRODUTO ";
    $sql = $sql."where id = '".$varId."'";
    //coloca o resultado do comando dentro da variavel rs
    $rs = mysqli_query($conexao,$sql);
    //transforma o rs em um array e coloca na variavel reg
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
  padding: 10px 200px 10px 15px;
  font-size: 16px;
  color: #333;
  cursor: pointer;
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
    <option value="Colombo" <?php if ($fabricante == "Colombo") echo "selected"; ?>>Colombo</option>
    <option value="Curitiba" <?php if ($fabricante == "Curitiba") echo "selected"; ?>>Curitiba</option>
    </select>
<label>Fornecedor:</label>
        <select name="cFornecedor" id="fornecedor" class="styled-select" required>
        <option value="">Selecione a opção</option>
        <option value="Colombo" <?php if ($fornecedor == "Colombo") echo "selected"; ?>>Colombo</option>
        <option value="Curitiba" <?php if ($fornecedor == "Curitiba") echo "selected"; ?>>Curitiba</option>
        </select>
<label>Tags:</label>
        <select name="cTags" id="tags" class="styled-select" required>
        <option value="">Selecione a opção</option>
        <option value="Colombo" <?php if ($tags == "Colombo") echo "selected"; ?>>Colombo</option>
        <option value="Curitiba" <?php if ($tags == "Curitiba") echo "selected"; ?>>Curitiba</option>
        </select>
<br>


<input type="submit" value="Enviar" name="b1" class="btn"><br>
</form>
<script>
    document.getElementById('produtoForm').addEventListener('submit', async (e) => {
  const data = {
    id: document.getElementById('id').value,
    ncm: document.getElementById('ncm').value,
    ecoflow_sku: document.getElementById('ecoflow_sku').value,
    name: document.getElementById('name').value,
    preco: document.getElementById('preco').value,
    fabricante: document.getElementById('fabricante').value,
    fornecedor: document.getElementById('fornecedor').value,
    tags: document.getElementById('tags').value
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

