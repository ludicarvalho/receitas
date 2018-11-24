<?php
include "banco.php";
$pdo = Banco::conectar();
$sql = "SELECT * FROM receitas ORDER BY titulo ASC";
$tam = "20"; // Tamanho da imagem e card na página
$alt = "16"; // Altura da imagem
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=0.9" />
    <link rel="shortcut icon" href="img/favicon.png" />
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <style>
    	img {
    		width: <?php echo $tam; ?>rem;
    		height: <?php echo $alt; ?>rem;
    	}
      .card {
        margin: 8px 0px 0px 0px;
      }
    </style>
    <title>Receitas</title>
</head>
<body>

<!-- Menu -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <span class="navbar-brand">Receitas</span>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="navbar-brand" href="index.php">Início <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item dropdown">
        <a class="navbar-brand dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Menu
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="criar.php" title="Adicionar nova receita">Cadastrar</a>
          <div class="dropdown-divider"></div><!-- Divisor de links no menu -->
		      <a class="dropdown-item" href="../../index.php" title="Sistema Casa Pessoal">Sistema</a>
          <a class="dropdown-item" href="../agenda/index.php" title="Contatos">Agenda</a>
          <a class="dropdown-item" href="../">Testes</a>
        </div>
      </li>
    </ul>

</nav>

<main role="main">
<!--  Aqui começa a página -->
<div class="jumbotron">
  <div class="container">
    <h1>Receitas Caseiras</h1>
  </div>
</div>
<div class="container">
<div class="row">
<?php
foreach($pdo->query($sql) as $row) {
if (strlen($row['titulo']) >= 20)
	$string = substr(trim($row['titulo']),0,23)."...";
else
	$string = $row['titulo'];
?>
    <div class="col-md-4">
        <div class="card" style="width: <?php echo $tam; ?>rem;">
            <img class="card-img-top" src="<?php echo $row['imagem']; ?>" alt="Imagem de <?php echo ucwords($row['titulo']); ?>" title="<?php echo ucwords($row['titulo']); ?>" />
                <div class="card-body">
                    <h5 class="card-title"><b><?php echo ucwords($string); ?></b></h5>
                    <a href="ler.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Ver</a>
                </div>
        </div>
    </div>

<?php }
?>
</div>
</div>

<br/> <br/>

<?php
rodape();
?>

</main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
