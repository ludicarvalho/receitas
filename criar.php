<?php 
$lin = "10";
$col = "90";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="img/favicon.png" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>Cadastrar Receita</title>
	<style>
		input#foto {
			display: none;
		}
		.favicon {
			width: 30px;
		}
	</style>
</head>
<body>

<div class="jumbotron">
	<h2 class="container">	
		<img src="img/favicon.png" alt="Cupcake" class="favicon">&nbsp;Cadastrar Receita
	</h2>
</div>

<div class="container">
	<form class="form-horizontal" action="criar.php" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label class="control-label col-sm-2" for="nome">Título:</label>
			<div class="col-sm-10">
				<input name="titulo" id="nome" type="text" maxlength="50" class="form-control" placeholder="Insira o título..." required value="<?php echo !empty($titulo)?$titulo:'';?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="sbnm">Ingredientes:<br/><br/>*colocar ; para pular linha</label>
			<div class="col-sm-10">          
				<textarea name="igrd" id="sbnm" class="form-control" rows="<?php echo $lin; ?>" cols="<?php echo $col; ?>"><h2 class="text-center">Sub-titulo</h2>;</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="apld">Modo de Preparo:<br/><br/>*colocar ; para pular linha</label>
			<div class="col-sm-10">          
				<textarea name="modopreparo" id="apld" class="form-control" rows="<?php echo $lin; ?>" cols="<?php echo $col; ?>"><h2 class="text-center">Sub-titulo</h2>;</textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2">Foto:</label>
			<div class="col-sm-10">
				<label for="foto">
					<div class="btn btn-info">Arquivo</div>
				</label>
				<input name="imgm" id="foto" type="file" />
			</div>
		</div>
		<div class="form-group">
			<a href="index.php" class="btn btn-primary">Voltar</a>
			<button class="btn btn-success">Cadastrar</button>
		</div>
	</form>
</div>

</body>
</html>
<?php
	require 'banco.php';
if (!empty($_POST)) {
	$titulo = $_POST['titulo'];
	$ingredientes = trim($_POST['igrd']);
	$modopreparo = trim($_POST['modopreparo']);

	//Inserindo no Banco:
  if(!empty($_FILES['imgm']['name'])) {
    $arq = substr($_FILES['imgm']['name'], -4);
    $inicionome = date('Ymd-His');
    $pastafoto = "img/$inicionome";
    $nomefoto = $pastafoto.$arq;
    move_uploaded_file($_FILES['imgm']['tmp_name'], $nomefoto);

	$pdo = Banco::conectar();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "INSERT INTO receitas (titulo, ingredientes, modopreparo, imagem) VALUES (?,?,?,?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($titulo, $ingredientes, $modopreparo, $nomefoto));
	Banco::desconectar();
	header("Location: index.php");
	
  }
  else {
    $pdo = Banco::conectar();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "INSERT INTO receitas (titulo, ingredientes, modopreparo) VALUES (?,?,?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($titulo, $ingredientes, $modopreparo));
	Banco::desconectar();
	header("Location: index.php");
  }
}
?>
