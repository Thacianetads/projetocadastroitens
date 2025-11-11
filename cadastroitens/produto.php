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
    width: 400px;
}

label {
    display: block;
    margin-top: 10px;
    color: #444;
    font-weight: 600;
}

input[type="text"] {
    width: 100%;
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
</style>
</head>
<body>

<div class="container">
    <h1>FORMULÁRIO PRODUTO</h1>
    <hr>
    <form action="gravaProduto.php" id="produtoForm" enctype="multipart/form-data" method="post">
        <label>Ncm:</label>
        <input type="text" id="ncm" name="cNcm" required>

        <label>Ecoflow_sku:</label>
        <input type="text" id="ecoflow_sku" name="cEcoflow_sku" required>

        <label>Name:</label>
        <input type="text" id="name" name="cName" required>

        <label>Cost_cents:</label>
        <input type="text" id="cost_cents" name="cCost_cents" required>

        <label>Price_cents:</label>
        <input type="text" id="price_cents" name="cPrice_cents" required>

        <label>Price_on_time_cents:</label>
        <input type="text" id="price_on_time_cents" name="cPrice_on_time_cents" required>
        <label>Atualizar imagem:</label><br>
        <input type="file" name="cImagem" accept="image/*"><br>  
        <input type="submit" value="Inserir" class="btn">
</div>

<script>
// --- JS para enviar para o webhook sem impedir o envio para PHP ---
document.getElementById('produtoForm').addEventListener('submit', function() {
    const data = {
        ncm: document.getElementById('ncm').value,
        ecoflow_sku: document.getElementById('ecoflow_sku').value,
        name: document.getElementById('name').value,
        cost_cents: document.getElementById('cost_cents').value,
        price_cents: document.getElementById('price_cents').value,
        price_on_time_cents: document.getElementById('price_on_time_cents').value
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
