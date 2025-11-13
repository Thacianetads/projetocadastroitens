<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>FORMULÁRIO PRODUTO</title>
<style>
/* --- Estilo geral --- */
body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #dfe9f3 0%, #ffffff 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}


.container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    padding: 30px 40px;
    width: 350px;
}

label {
    display: block;
    margin-top: 10px;
    color: #444;
    font-weight: 600;
}

input[type="text"] {
    width: 93%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-top: 5px;
    font-size: 14px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input[type="file"] {
    width: 93%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    margin-top: 5px;
    font-size: 14px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input:focus {
    border-color: #0078d7;
    box-shadow: 0 0 5px rgba(0,120,215,0.4);
    outline: none;
}

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
    <h1>Cadastrar itens</h1>
    <hr>
    <form action="gravaProduto.php" id="produtoForm" enctype="multipart/form-data" method="post">
        <label>NCM: </label>
        <input type="text" id="ncm" name="cNcm" required>

        <label>SKU: </label>
        <input type="text" id="ecoflow_sku" name="cEcoflow_sku" required>

        <label>Nome do produto:</label>
        <input type="text" id="name" name="cName" required>
        <br>
        <label>Preço:</label>
        <input type="text" id="preco" name="cPreco" required>
        <br>
        <label>Fabricante:</label>
        <SELECT name = "cFabricante" id="fabricante" class="styled-select" required><br><br>
        <OPTION SELECT VALUE ="Selecione a opção">Selecione a opção
        <OPTION SELECT VALUE ="PGYTECH">PGYTECH
        <OPTION SELECT VALUE ="DJI">DJI
        <OPTION SELECT VALUE ="ECOFLOW">ECOFLOW
        <OPTION SELECT VALUE ="AUTEL">AUTEL
        <OPTION SELECT VALUE ="MICASENSE">MICASENSE
        <OPTION SELECT VALUE ="SPACEX">SPACEX
        </SELECT><br>

        <label>Fornecedor:</label>
        <SELECT name = "cFornecedor" id="fornecedor" class="styled-select" required><br><br>
        <OPTION SELECT VALUE ="Selecione a opção">Selecione a opção
        <OPTION SELECT VALUE ="MULTILASER">MULTILASER
        <OPTION SELECT VALUE ="INTELBRAS">INTELBRAS
        <OPTION SELECT VALUE ="TIMBER">TIMBER
        <OPTION SELECT VALUE ="GOLDEN DISTRIBUIDORA LTDA">GOLDEN DISTRIBUIDORA LTDA
        <OPTION SELECT VALUE ="GOHOBBYT FUTURE TECHNOLOGY LTDA">GOHOBBYT FUTURE TECHNOLOGY LTDA
        <OPTION SELECT VALUE ="ALLCOMP">ALLCOMP
        <OPTION SELECT VALUE ="DRONENERDS">DRONENERDS
        <OPTION SELECT VALUE ="SANTIAGO & SINTRA">SANTIAGO & SINTRA
        <OPTION SELECT VALUE ="POWERSAFE">POWERSAFE
        <OPTION SELECT VALUE ="AGEAGLE AERIAL SYSTEMS INC">AGEAGLE AERIAL SYSTEMS INC
        <OPTION SELECT VALUE ="STARLINK">STARLINK
        </SELECT><br>

        <label>Tags:</label>
        <SELECT name = "cTags" id="tags" class="styled-select" required><br><br>
        <OPTION SELECT VALUE ="Selecione a opção">Selecione a opção
        <OPTION SELECT VALUE ="Agras">Agras
        <OPTION SELECT VALUE ="Consumer">Consumer
        <OPTION SELECT VALUE ="DEMO">DEMO
        <OPTION SELECT VALUE ="DN">DN
        <OPTION SELECT VALUE ="Ecoflow">Ecoflow
        <OPTION SELECT VALUE ="Enterprise">Enterprise
        <OPTION SELECT VALUE ="Pecas">Pecas
        <OPTION SELECT VALUE ="Starlink">Starlink
        <OPTION SELECT VALUE ="Treinamento">Treinamento
        </SELECT><br>
        
        <label>Adicionar imagem:</label>
        <input type="file" id="imagem" name="cImagem" accept="image/*"><br>  
        <input type="submit" value="Inserir" class="btn">
    </form>
</div>

<script>
// --- JS para enviar para o webhook sem impedir o envio para PHP ---
document.getElementById('produtoForm').addEventListener('submit', function() {
    const data = {
        ncm: document.getElementById('ncm').value,
        ecoflow_sku: document.getElementById('ecoflow_sku').value,
        name: document.getElementById('name').value,
        preco: document.getElementById('preco').value,
        fabricante: document.getElementById('fabricante').value,
        tags: document.getElementById('tags').value,
        imagem: document.getElementById('imagem').value
    };

    fetch('https://n8n-cwb-main-webhook-test.nwdrones.com.br/webhook/cadastroproduto', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            console.error('Erro ao enviar para o webhook:', response.statusText);
        }
    })
    .catch(error => {
        console.error('Erro na requisição do webhook:', error);
    });
});
</script>

</body>
</html>
