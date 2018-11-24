<?php
require 'banco.php';

$id = 0;
$usr = $_GET['usr'];

if (!empty($_GET['id'])) {
	$id = $_GET['id'];

}

if (!empty($_POST)) {
    $id = $_POST['id'];
    //Delete do banco:
    $pdo = Banco::conectar();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DELETE FROM receitas WHERE id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    Banco::desconectar();
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="../../crudLudi/estilo.css" />
	<title>Excluir Receita</title>
</head>
<body>
	<div>
		<h1>Excluir Receita</h1>
	</div>
		<form action="apagar.php" method="post">

			<input type="hidden" name="id" value="<?php echo $id;?>"/>
			<p class="aviso">Deseja excluir <?php echo $usr; ?>?<br/>
			Não haverá como voltar se excluir</p>

		<p class="cent"><a href="javascript:history.back()" class="btn">Não</a> <button type="submit" class="btn">Sim</button></p>
	</form>
</body>
</html>
