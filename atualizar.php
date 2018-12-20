<?php
require "banco.php";

$id = null;
if ( !empty($_GET['id'])) {
	$id = $_REQUEST['id'];
}

if ( null==$id ) {
	header("Location: index.php");
}

if (!empty($_POST)) {
	$tituloErro = null;
	$ingredientesErro = null;
	$modopreparoErro = null;

	$titulo = $_POST['titulo'];
	$ingredientes = trim($_POST['igrd']);
	$modopreparo = trim($_POST['modopreparo']);

	//Validação
	$validacao = true;
	if (empty($titulo)) {
		$tituloErro = 'Por favor, digite o nome da Receita!';
		$validacao = false;
	}

	if (empty($ingredientes)) {
		$ingredientesErro = 'Por favor, digite os ingredientes!';
		$validacao = false;
	}

	if (empty($modopreparo)) {
		$modopreparoErro = 'Por favor, digite o modo de preparo!';
		$validacao = false;
	}

	// update data
	if ($validacao) {
		$pdo = Banco::conectar();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$arq = substr($_FILES['imgm']['name'], -4);
		$inicionome = date('Ymd-His');
		$pastafoto = "img/$inicionome";
		$nomefoto = $pastafoto.$arq;

		if(!empty($_FILES['imgm']['name'])) {
			move_uploaded_file($_FILES['imgm']['tmp_name'], $nomefoto);

			$sql = "UPDATE receitas SET titulo = ?, ingredientes = ?, modopreparo = ?, imagem = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($titulo,$ingredientes,$modopreparo,$nomefoto, $id));
			Banco::desconectar();

			header("Location: ler.php?id=$id");
		}
		else {
			$sql = "UPDATE receitas SET titulo = ?, ingredientes = ?, modopreparo = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($titulo,$ingredientes,$modopreparo, $id));
			Banco::desconectar();
			header("Location: ler.php?id=$id");
		}
	}
}
else {
	$pdo = Banco::conectar();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM receitas WHERE id = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$titulo = $data['titulo'];
	$ingredientes = $data['ingredientes'];
	$modopreparo = $data['modopreparo'];
	Banco::desconectar();
}

$lin = "10";
$col = "100";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
	<link rel="stylesheet" href="bootstrap/estilo.css" />
	<link rel="shortcut icon" href="img/favicon.png" />
	<script src="bootstrap/jquery.min.js"></script>
	<script src="bootstrap/bootstrap.min.js"></script>
	<title>Atualizar Receita</title>
	<style>
		.favicon {width: 30px; vertical-align: middle;}
	</style>
</head>
<body>

<div class="jumbotron">
	<div class="container">
		<h2><img src="img/favicon.png" alt="Cupcake" class="favicon"> Atualizar Receita</h2>
	</div>
</div>

<div class="container">
	<form class="form-horizontal" action="atualizar.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
		<div class="form-group">
<?php echo !empty($tituloErro)?'error':'';?>
			<label class="control-label col-sm-2" for="nome">Título:</label>
			<div class="col-sm-10">
				<input type="text" maxlength="50" class="form-control" id="nome" placeholder="Insira o título..." name="titulo" required value="<?php echo !empty($titulo)?$titulo:'';?>" />
<?php if (!empty($tituloErro)): ?><?php echo $tituloErro; ?><?php endif; ?>
			</div>
		</div>
		<div class="form-group">
<?php echo !empty($ingredientesErro)?'error':'';?>
			<label class="control-label col-sm-2" for="sbnm">Ingredientes:</label>
				<div class="col-sm-10">          
        			<textarea id="sbnm" name="igrd" class="form-control" rows="<?php echo $lin; ?>" cols="<?php echo $col; ?>"><?php echo !empty($ingredientes)?$ingredientes:'';?></textarea>
<?php if (!empty($ingredientesErro)): ?><?php echo $ingredientesErro;?><?php endif; ?>
				</div>
		</div>
		<div class="form-group">
<?php echo !empty($modopreparoErro)?'error':'';?>
			<label class="control-label col-sm-2" for="apld">Modo de Preparo:</label>
			<div class="col-sm-10">          
				<textarea name="modopreparo" class="form-control" id="apld" rows="<?php echo $lin; ?>" cols="<?php echo $col; ?>"><?php echo !empty($modopreparo)?$modopreparo:'';?></textarea>
<?php if (!empty($modopreparoErro)): ?><?php echo $modopreparoErro;?><?php endif; ?>
				<br/>
				<a href="index.php" class="btn btn-secondary btao">Voltar</a>
				<button class="btn btn-success btao">Atualizar</button>
<?php if (file_exists($data['imagem'])) { ?>
				<a href="apgimg.php?id=<?php echo $data['id']; ?>&pth=<?php echo $data['imagem']; ?>" class="btn btn-danger btao" target="_blank">Apagar imagem</a>
<?php }
else {
?>
				<label class="disp" for="foto">
					<div class="btn btn-info btao">Arquivo</div>
				</label>
				<input name="imgm" id="foto" type="file" class="oculto" />
<?php
}
?>
			</div>
		</div>
	</form>
</div>

<?php rodape(); ?>

</body>
</html>
