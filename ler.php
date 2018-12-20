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

if (empty($_GET['pag']))
	$pagina = 1;
else
	$pagina = $_GET['pag'];

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=0.9">
	<link rel="shortcut icon" href="img/favicon.png" />
	<link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
	<link rel="stylesheet" href="bootstrap/estilo.css" />
	<script src="bootstrap/jquery.js"></script>
	<title>Receita - <?php echo ucwords($data['titulo']); ?></title>
</head>
<body>

<!-- Menu -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
	<div class="container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#me" aria-controls="me" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="me">
			<ul class="navbar-nav">
				<li>
					<a class="navbar-brand" href="index.php">Início</a>
				</li>
				<li class="nav-item dropdown">
					<a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Menu
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="atualizar.php?id=<?php echo $data['id']; ?>">Atualizar Receita</a>
						<a class="dropdown-item" href="apagar.php?id=<?php echo $data['id']; ?>&nr=<?php echo ucwords($data['titulo']); ?>">Apagar Receita</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- -->

<div class="jumbotron">
	<div class="container">
		<h1 class="text-center"><?php echo ucwords($data['titulo']); ?></h1>
	</div>
</div>

<div class="container">
    <ul class="list-group">
    <li class="list-group-item bg-dark">
      <h1 class="text-center text-white">Ingredientes</h1>
    </li>
    <li class="list-group-item">
<?php
echo str_replace(";", "\n\t</li>\n\t<li class='list-group-item'>", $data['ingredientes']);
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
echo str_replace(";", "\n\t</li>\n\t<li class='list-group-item'>", $data['modopreparo']);
?>

    </li>
    </ul>
<br/>
	<div class="ali">
		<a href="index.php?pagina=<?php echo $pagina; ?>" class="btn btn-secondary">Voltar</a>
	</div>
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
