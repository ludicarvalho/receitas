<?php
require 'banco.php';

$id = 0;
$nr = 0;

if (!empty($_GET['id'])) {
	$id = $_GET['id'];
	$nr = $_GET['nr'];
}

// Informação


if (!empty($_POST)) {
	$id = $_POST['id'];
	$pdoo = Banco::conectar();
	$pdoo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$qry = "SELECT * FROM receitas WHERE id = ?";
	$qqq = $pdoo->prepare($qry);
	$qqq->execute(array($id));
	$dado = $qqq->fetch(PDO::FETCH_ASSOC);
	$local = $dado['imagem'];
	$deletar = unlink($local);
	Banco::desconectar();
	//Delete do banco:
	if ($deletar) {
		$pdo = Banco::conectar();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM receitas WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Banco::desconectar();
		header('Location: index.php');
	}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="bootstrap/principal.css" />
	<title>Excluir Receita</title>
</head>
<body>
	<div class="excluir">
		<p class="centro titulo">Excluir Receita</p>
		<form action="apagar.php" method="post">

			<input type="hidden" name="id" value="<?php echo $id;?>"/>
			<p class="centro">Deseja excluir <?php echo $nr; ?>?<br/>
			Não haverá como voltar se excluir</p>

			<p class="centro">
				<a href="javascript:history.back()" class="botao">Não</a>
				<button type="submit" class="botao">Sim</button>
			</p>
		</form>
	</div>
</body>
</html>
