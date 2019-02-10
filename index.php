<?php
include "banco.php";
$pdo = Banco::conectar();
$tam = "20.5"; // Tamanho da imagem e card na página
$alt = "16.5"; // Altura da imagem

//Somar a quantidade de itens
$result_pg = "SELECT COUNT(id) AS num_result\n"
			."FROM receitas";
$resultado_pg = Banco::conectar()->prepare($result_pg);
$resultado_pg->execute();
$row_pg = $resultado_pg->fetch(PDO::FETCH_ASSOC);

//Setar a quantidade de itens por página
$qtd_result_pg = 3; // era 19 itens

//Quantidade de páginas
$aaa = $row_pg['num_result'];
$quantidade_pg = ceil($aaa / $qtd_result_pg);

//Receber o número da página
$pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
$pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

//Calcular o início da visualização
$inicio = ($qtd_result_pg * $pagina) - $qtd_result_pg;
if (empty($_GET))
	$vari = 1;
else
	$vari = $_GET['pagina'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="img/favicon.png" />
	<link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
	<link rel="stylesheet" href="bootstrap/estilo.css" />
    <script src="bootstrap/jquery.js"></script>
    <style>
    	img {
    		width: <?php echo $tam; ?>rem;
    		height: <?php echo $alt; ?>rem;
		}
    </style>
    <title>Receitas</title>
</head>
<body>

<!-- Menu -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
	<div class="container">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#me" aria-controls="me" aria-expanded="false" aria-label="Toggle navigation">
    	<span class="navbar-toggler-icon"></span>
    </button>
		<div class="collapse navbar-collapse" id="me">
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
				<li>
					<a class="navbar-brand" href="index.php">Início <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item dropdown">
					<a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Menu
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="criar.php" title="Adicionar nova receita">Cadastrar</a>
						<div class="dropdown-divider"></div><!-- Divisor de links no menu -->
						<a class="dropdown-item" href="../../" title="Sistema Casa Pessoal">Sistema</a>
						<a class="dropdown-item" href="../agenda/index.php" title="Contatos">Agenda</a>
						<a class="dropdown-item" href="../">Testes</a>
					</div>
				</li>
			</ul>
			<form class="form-inline mt-2 mt-md-0" method="post" action="buscar.php?pagina=1">
				<input class="form-control mr-sm-2" name="obj" type="text" placeholder="Buscar" aria-label="Search" required />
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
			</form>
		</div>
	</div>
</nav>

<main role="main">
<!--  Aqui começa a página -->
<div class="container">
	<h1>Receitas Juliane</h1>
</div>

<div class="container">
	<div class="row">
<?php
$sql = "SELECT *\n"
	. "FROM receitas\n"
	. "ORDER BY titulo ASC\n"
	. "LIMIT $inicio, $qtd_result_pg";
foreach($pdo->query($sql) as $row) {
if (strlen($row['titulo']) >= 20)
	$string = substr(trim($row['titulo']),0,23)."...";
else
	$string = $row['titulo'];
?>

		<div class="col-md-4"> <!-- Receita <?php echo $row['id']; ?> -->
			<div class="card" style="width: <?php echo $tam; ?>rem;">
				<img class="card-img-top" src="<?php echo $row['imagem']; ?>" alt="Imagem de <?php echo ucwords($row['titulo']); ?>" onmouseover="toolTip('<b><?php echo ucwords($row['titulo']); ?></b>')" onmouseout="toolTip()" />
				<div class="card-body">
					<h5 class="card-title"><b><?php echo ucwords($string); ?></b></h5>
					<a href="ler.php?id=<?php echo $row['id']; ?>&pag=<?php echo $pagina; ?>" class="btn btn-outline-secondary">Ver</a>
				</div>
			</div>
		</div>
<?php }
Banco::desconectar();
?>

	</div>
</div>

<br/>

<?php if ($quantidade_pg > 1) {
?>
<nav aria-label="Navegação">
<?php
// Paginação

//echo "<p>" . $row_pg['num_result'] . "</p>";

//Limitar a quantidade de Links antes e depois
$max_links = 3;
?>
	<ul class="pagination justify-content-center">
<?php if ($vari == 1 || empty($vari)) {
?>
		<li class="page-item disabled">
			<a href="#" class="page-link" title="Primeira página">&laquo;</a>
		</li>
<?php }
		elseif ($vari <= $quantidade_pg and $vari >= 1) {
?>
		<li class="page-item">
			<a class="page-link" href="index.php?pagina=1" title="Primeira página">&laquo;</a>
		</li>
<?php
		}
		elseif ($vari <= 0) {
			header("Location: index.php?pagina=1");
		}
		for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
			if ($pag_ant >= 1) { ?>
		<li class="page-item">
			<a class="page-link" href="index.php?pagina=<?php echo $pag_ant; ?>" title="Página <?php echo $pag_ant; ?>"><?php echo $pag_ant; ?></a>
		</li>
<?php		}
		}
?>
		<li class="page-item disabled">
			<a href="#" class="page-link" title="<?php echo $pagina; ?>"><?php echo $pagina; ?></a>
		</li>
<?php 
		for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
			if ($pag_dep <= $quantidade_pg) { ?>
		<li class="page-item">
			<a class="page-link" href="index.php?pagina=<?php echo $pag_dep; ?>" title="Página <?php echo $pag_dep; ?>"><?php echo $pag_dep; ?></a>
		</li>
<?php 		}
		}
if ($vari == $quantidade_pg) { ?>
		<li class="page-item disabled">
			<a href="#" class="page-link" title="Última página">&raquo;</a>
		</li>
<?php }

elseif ($vari != $quantidade_pg and $vari <= $quantidade_pg) { ?>
		<li class="page-item">
			<a href="index.php?pagina=<?php echo $quantidade_pg; ?>" class="page-link" title="Última página">&raquo;</a>
		</li>
<?php }
else {
header("Location: index.php?pagina=$quantidade_pg");
}
?>
	</ul>
</nav>
<?php }
?>

<br/>

<?php
rodape();
?>

</main>

<?php include "bootstrap/scripts.html"; ?>

</body>
</html>
