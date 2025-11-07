<html>
<head>
    <meta charset="UTF-8">
    <title> FORMULÁRIO PRODUTO </title>
    <style>

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
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    padding: 30px 40px;
    width: 400px;
    animation: fadeIn 0.4s ease;
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
</style>
</head>
<body>
<div class="container">    
<h1 class="w3-center">FORMULÁRIO PRODUTO</h1><hr><br>
<form action="gravaProduto.php" id="produtoForm" method="post" enctype="multipart/form-data"> 
<label> Ncm: </label><br>
<input type="text" id="ncm" name="cNcm" required><br>
<br>
<label> Ecoflow_sku: </label><br>
<input type="text" id="ecoflow_sku" name="cEcoflow_sku" required><br>
<br>
<label> Name: </label><br>
<input type="text" id="name" name="cName" required><br>
<br>
<label> Cost_cents: </label><br>
<input type="text" id="cost_cents" name="cCost_cents" required><br>
<br>
<label> Price_cents: </label><br>
<input type="text" id="price_cents" name="cPrice_cents" required><br>
<br>
<label> Price_on_time_cents: </label><br>
<input type="text" id="price_on_time_cents" name="cPrice_on_time_cents" required><br>
<br>

<input type="submit" value="Inserir" name="b1" class="btn"><br>
</form>
</div>
<script>
  document.getElementById('produtoForm').addEventListener('submit', async function(e) {
    e.preventDefault(); // previne o envio tradicional do formulário

    // coleta os dados do formulário
    const data = {
      ncm: document.getElementById('ncm').value,
      ecoflow_sku: document.getElementById('ecoflow_sku').value,
      name: document.getElementById('name').value,
      cost_cents: document.getElementById('cost_cents').value,
      price_cents: document.getElementById('price_cents').value,
      price_on_time_cents: document.getElementById('price_on_time_cents').value
    };

    try {
      // envia os dados para o webhook usando POST
      const response = await fetch('https://n8n-cwb-main-webhook-test.nwdrones.com.br/webhook/8d52a45b-7e38-4a90-888b-3a89b5c682bf', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      });

      if(response.ok) {
        alert('Dados enviados com sucesso!');
        echo '<meta http-equiv="refresh" content="0;URL=consultaProduto.php">';
      } else {
        alert('Erro ao enviar os dados: ' + response.statusText);
      }
    } catch (error) {
      alert('Erro na requisição: ' + error.message);
    }
  });
</script>

</body>
</html>