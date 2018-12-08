<?php
include "banco.php";
$id = null;

if (!empty($_GET['id'])) {
	$id = $_GET['id'];
}

if (null==$id) {
	header("Location: index.php");
}

else {
	$pdo = Banco::conectar();
	$sql = "SELECT * FROM receitas WHERE id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="img/favicon.png" />
	<link rel="stylesheet" href="bootstrap/bootstrap.css" />
	<script src="bootstrap/jquery.js"></script>
	<title>Receita - <?php echo ucwords($data['titulo']); ?></title>
	<style>
	.footer {
		background-color: #f5f5f5;
	}
	</style>
</head>
<body>

<!-- Menu -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<span class="navbar-brand">Receita&nbsp;</span>
	<ul class="navbar-nav mr-auto">
		<li class="nav-item active">
			<a class="nav-link" href="index.php">Início</a>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Menu
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" href="atualizar.php?id=<?php echo $data['id']; ?>">Atualizar Receita</a>
				<a class="dropdown-item" href="apagar.php?id=<?php echo $data['id']; ?>&usr=<?php echo ucwords($data['titulo']); ?>">Apagar Receita</a>
			</div>
		</li>
	</ul>
</nav>
<!-- -->

<br/>
<div class="jumbotron">
	<div class="container">
		<h1><?php echo ucwords($data['titulo']); ?></h1>
	</div>
</div>

<div class="container">
    <ul class="list-group">
		<li class="list-group-item bg-dark">
			<h1 class="text-center text-white">Ingredientes</h1>
		</li>
		<li class="list-group-item">
<?php
echo str_replace(";", "\n</li>\n\n<li class='list-group-item'>", $data['ingredientes']);
?>

    	</li>
    </ul>

<br/>

	<ul class="list-group">
		<li class="list-group-item bg-dark">
			<h1 class="text-center text-white">Modo de Preparo</h1>
		</li>
		<li class="list-group-item">
<?php
echo str_replace(";", "\n</li>\n<li class='list-group-item'>", $data['modopreparo']);
?>

		</li>
	</ul>
	<a href="index.php" class="btn btn-primary">Voltar</a>
</div>

<br/>

<?php rodape(); ?>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="bootstrap/jquery-3.3.1.slim.min.js"></script>
<script>window.jQuery || document.write('<script src="bootstrap/jquery-slim.min.js"><\/script>')</script>
<script src="bootstrap/popper.min.js"></script>
<script src="bootstrap/bootstrap.min.js"></script>

</body>
</html>
