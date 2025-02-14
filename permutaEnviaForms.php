<?php
include "db.php";

$ndata =         htmlspecialchars($_POST['dataop'], ENT_QUOTES, 'UTF-8');
//$hora =         htmlspecialchars($_POST['hora'], ENT_QUOTES, 'UTF-8');
$in1888 =       htmlspecialchars($_POST['in1888'], ENT_QUOTES, 'UTF-8');
$tipoop =       htmlspecialchars($_POST['tipoop'], ENT_QUOTES, 'UTF-8');
$ativo_id =     htmlspecialchars($_POST['ativo_id'], ENT_QUOTES, 'UTF-8');
$valorunitario = htmlspecialchars($_POST['valorunitario'], ENT_QUOTES, 'UTF-8');
$quantidade =   htmlspecialchars($_POST['quantidade'], ENT_QUOTES, 'UTF-8');
$valortotal =   filter_input(INPUT_POST, 'valortotal', FILTER_SANITIZE_NUMBER_INT);
$taxa =         filter_input(INPUT_POST, 'taxa', FILTER_SANITIZE_NUMBER_INT);
$exchange =     htmlspecialchars($_POST['exchange'], ENT_QUOTES, 'UTF-8');
$corretora =    htmlspecialchars($_POST['corretora'], ENT_QUOTES, 'UTF-8');
$dataop =       htmlspecialchars($_POST['dataop'], ENT_QUOTES, 'UTF-8');
$criptode =     htmlspecialchars($_POST['criptode'], ENT_QUOTES, 'UTF-8');
$qtdede =       filter_input(INPUT_POST, 'qtdede', FILTER_SANITIZE_NUMBER_FLOAT);
$vunit =        filter_input(INPUT_POST, 'vunit', FILTER_SANITIZE_NUMBER_FLOAT);
$valortotalde = filter_input(INPUT_POST, 'valortotalde', FILTER_SANITIZE_NUMBER_FLOAT);
$criptopara =   htmlspecialchars($_POST['criptopara'], ENT_QUOTES, 'UTF-8');
$qtdepara =     filter_input(INPUT_POST, 'qtdepara', FILTER_SANITIZE_NUMBER_FLOAT);
$criptotaxa =   htmlspecialchars($_POST['criptotaxa'], ENT_QUOTES, 'UTF-8');
$qtdetaxa =     filter_input(INPUT_POST, 'qtdetaxa', FILTER_SANITIZE_NUMBER_FLOAT);
$vunittaxa =    filter_input(INPUT_POST, 'vunittaxa', FILTER_SANITIZE_NUMBER_FLOAT);
$valortaxa =    filter_input(INPUT_POST, 'valortaxa', FILTER_SANITIZE_NUMBER_FLOAT);
$dolarptax =    filter_input(INPUT_POST, 'dolarptax', FILTER_SANITIZE_NUMBER_FLOAT);
$valop =        filter_input(INPUT_POST, 'valop', FILTER_SANITIZE_NUMBER_FLOAT);
$valorrs =       filter_input(INPUT_POST, 'valorrs', FILTER_SANITIZE_NUMBER_FLOAT);
$taxars =       filter_input(INPUT_POST, 'taxars', FILTER_SANITIZE_NUMBER_FLOAT);
$ndata = htmlspecialchars($_POST['dataop'], ENT_QUOTES, 'UTF-8');
//    $hora = htmlspecialchars($_POST['hora'], ENT_QUOTES, 'UTF-8');
//$ndata = date("Y-m-d H:i:s");
//$hora = date("H:i:s");
//2025-12-12 18:18:36
//18:18:36
$novadata = substr($ndata, 8, 2) . "/" . substr($ndata, 5, 2) . "/" . substr($ndata, 0, 4);
$novahora = substr($ndata, 11, 2) . "h" . substr($ndata, 14, 2)  . "m" . substr($ndata, 17, 2) . "s";

//$novahora=substr($hora,0,2) ."h" .substr($hora,3,2)  ."m" .substr($hora,6,2) . "s" ;
$horabr = substr($novahora, 0, 2);
$horaconv = (int)$horabr;
$horagmt = $horaconv + 3;
$horagmt = $horagmt . "h" . substr($novahora, 3, 2) . "min" . substr($novahora, 6, 2) . "s";
echo  "Nova hora BR: $novahora";
echo "<br>";
echo "Hora GMT: $horagmt";

$criptopara = "BTC";

if (isset($criptopara)) {
    // Preparar e executar consulta
    $stmt = $conn->prepare("
        SELECT 
        saldoinicial_total, 
        saldofinal_total, 
        custo_medio_de_aquisicao, 
        valor_em_estoque, 
        carteira, 
        saldo_inicial_carteira, 
        saldo_final_carteira, 
        id_operacao, 
        `hash-exchange` 
        FROM memorial WHERE 
        crypto = 
        ?");
    $stmt->bind_param("s", $criptopara);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr>
        <th>Saldo Inicial Total</th><th>Saldo Final Total</th><th>Custo Médio</th><th>Valor em Estoque</th>
        <th>carteira</th><th>saldo_inicial_carteira</th><th>saldo_final_carteira</th><th>id_operacao</th>
        <th>hash_exchange</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row["saldoinicial_total"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["saldofinal_total"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["custo_medio_de_aquisicao"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["valor_em_estoque"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["carteira"]) . '</td>';

            echo '<td>' . htmlspecialchars($row["saldo_inicial_carteira"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["saldo_final_carteira"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["id_operacao"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["hash_exchange"]) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "Nenhum ativo cadastrado.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Erro: Variável 'criptopara' não definida.";
}



// Saldo Final Carteira
    if($crypto == $criptoativo_de){
        $saldo_final_carteira = $saldo_final_carteira - $qtdede;
        echo "Saldo Final Carteira = $saldo_final_carteira";
    }
    else if($crypto == $criptopara){
        $saldo_final_carteira = $saldo_final_carteira + $qtdepara;
        echo "Saldo Final Carteira = $saldo_final_carteira";
    }
    if($crypto == $criptotaxa){
        $saldo_final_carteira = $saldo_final_carteira - $qtdetaxa;
        echo "Saldo Final Carteira = $saldo_final_carteira";
    }


/*
// valor em estoque
//if($tipo_operacao ==)

//Custo Medio
if ($crypto == "$criptopara") {
    if ($tipo_operacao = "compra" || $tipo_operacao = "permuta") {
        $valorEmEstoque = $valorEmEstoque - $valor_da_Operacao;
        $saldoFinal_Carteira = $saldoFinal_Carteira - $qtdede;
    }
}


//campos
/*$data;
    $hora;
    tipoop
    $ativo_id;
    $valorunitario;
    $quantidade;
    $valortotal;
    $taxa;
    $exchange;
    $corretora;
    */


if (
    !$tipoop || !$ativo_id || !$valorunitario
    || !$quantidade || !$valortotal || !$taxa ||
    !$exchange || !$corretora || !$dataop ||
    !$criptode || !$qtdede || !$vunit ||
    !$valortotalde || !$criptopara || !$qtdepara ||
    !$criptotaxa || !$qtdetaxa || !$vunittaxa ||
    !$valortaxa || !$dolarptax || !$valop ||
    !$valors || !$taxars
) {
    die("Dados insuficientes para cadastrar a operacao.");
}

// Calculo do Custo Médio de Aquisição
//$cmaqatual = "select 
$cmaq = 1;
// Valor da Operação
$valop = $qtdede *  $vunit;



$stmt = $conn->prepare("INSERT INTO movimentacao (data, hora, horagmt, ativo_id, valor_unitario,
                         quantidade, valor_total, operacao) 
                            VALUES ( ?, ?, ?, ?, ?, ?,  ?, ?) 
                            ON DUPLICATE KEY UPDATE 
                            ativo_id = VALUES(ativo_id),
                            data = VALUES(data), 
                            hora = VALUES(novahora), 
                            horagmt = VALUES(horagmt), 
                            valor_unitario = VALUES(valorunitario),
                            quantidade = VALUES(quantidade),
                            valor_total = VALUES(valortotal),
                            taxa = VALUES(taxa),
                            exchange = VALUES(exchange),
                            corretora = VALUES(corretora),
                            ");
$stmt->bind_param("sssi", $nome, $dexcex, $nacional, $pais_id);

if (!$stmt->execute()) {
    error_log("Erro ao inserir no banco: " . $stmt->error);
    echo "Ocorreu um erro ao processar o cadastro.";
} else {
    echo "Cadastro realizado com sucesso!";
    //header("Location: corretoras_create.php?ac=sucesso");
    //exit;
}

$stmt->close();

$conn->close();

/*id -> automatico
faremos um select no banco de dados, capturando os campos que precisam dos dados armazenados, os quais são
	saldoinicial_total
	saldofinal_total
	custo_medio_de_aquisicao
	valor_em_estoque
	carteira
	saldo_inicial_carteira
	saldo_final-carteira



crypto -> 
se permuta  3 operacoes
	1 -> saída (ativo de)
	1 -> entrada (ativo para)
	1 -> taxa (taxa)

se venda 2 operacoes
	1 -> saída (ativo de)
	1 -> taxa (taxa)
se compra 2 operacoes
	1 -> entrada (ativo para)
	1 -> taxa (taxa)



data_brasil 	(script de insercao da data de compra (GMT -3))
data_utc	(script de insercao da data de compra(GMT)))
saldoinicial_total (saldo inicial da carteira - obtido através do select)
entrada (se ativo para, a quantidade de ativos, a ser inserida)
saida	(se ativo de, a quantidade de ativos, a ser removida)
saida_taxa (a quantidade de taxa da operacao)
	
	para evitar redundância, será criado 3 inserções no banco de dados, mas os cálculos serão 	realizados uma única vez, armazenando os dados em variável

saldofinal_total
	se (crypto = ativo_de)
		saldofinal_total = saldofinal_total - qtde_ativo_de
	se (crypto = ativo_para)
		saldofinal_total = saldofinal_total + qtde_ativo_para
	se (crypto = ativo_para)
		saldofinal_total = saldofinal_total + qtde_ativo_para

	se (crypto = taxa)
		saldofinal_total = saldofinal_total - qtde_taxa

custo_medio_de_aquisicao
	se (crypto = ativo_de)
		custo_medio_de_aquisicao = custo_medio_de_aquisicao
	se (crypto = ativo_taxa)
		custo_medio_de_aquisicao = custo_medio_de_aquisicao
	se (crypto = ativo_para)
		custo_medio_de_aquisicao = (custo_medio_de_aquisicao + valor_operacao)/(saldoinicial_total + qtde_para)



valor_em_estoque
	se (crypto = ativo_de)
		saldofinal_total = saldofinal_total - valor_operacao

	se (crypto = ativo_para)
		saldofinal_total = saldofinal_total - valor_operacao

	se (crypto = taxa)
		saldofinal_total = saldofinal_total - valor_taxa


carteira
saldo_inicial_carteira
	busca no banco de dados o valor inicial em carteira

saldo_final-carteira
	select saldo_final-carteira from memorial where carteira = "carteira" and ativo = ativo
	se (crypto = ativo_de)
		saldoinicial_carteira = saldoinicial_carteira - qtde_de

	se (crypto = ativo_para)
		saldoinicial_carteira = saldoinicial_carteira - qtde_taxa

	se (crypto = taxa)
		saldoinicial_carteira = saldoinicial_carteira + qtde_taxa


id_operacao
arquivo_importacao
hash-exchange
tipo_in_1888
tipo_operacao
criptoativo_de
Qtde_de	criptoativo_para
Qtde_Para
Criptoativo_taxa
Qtde_Taxa
dolarPtax
Valor_Opercao_(R$)
Valor_Taxa_(R$)
*/