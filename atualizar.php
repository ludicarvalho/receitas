<?php
	require "banco.php";

	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}

	if ( !empty($_POST)) {
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
			$sql = "UPDATE `receitas` SET `titulo` = ?, `ingredientes` = ?, `modopreparo` = ? WHERE `id` = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($titulo,$ingredientes,$modopreparo, $id));
			Banco::desconectar();
			header("Location: ler.php?id=$id");
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
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
	<link rel="shortcut icon" href="img/favicon.png" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<title>Atualizar Receita</title>
	<style>
		.favicon {
			width: 30px;
		}
	</style>
</head>
<body>

<div class="jumbotron">
  <div class="container">
    <h2><img src="img/favicon.png" alt="Cupcake" class="favicon"> Atualizar Receita</h2>
  </div>
</div>

<div class="container">
  <form class="form-horizontal" action="atualizar.php?id=<?php echo $id; ?>" method="post">
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
<?php if (!empty($ingredientesErro)): ?> <?php echo $ingredientesErro;?> <?php endif; ?>
      </div>
    </div>
    <div class="form-group">
<?php echo !empty($modopreparoErro)?'error':'';?>
      <label class="control-label col-sm-2" for="apld">Modo de Preparo:</label>
      <div class="col-sm-10">          
        <textarea name="modopreparo" class="form-control" id="apld" rows="<?php echo $lin; ?>" cols="<?php echo $col; ?>"><?php echo !empty($modopreparo)?$modopreparo:'';?></textarea>
<?php if (!empty($modopreparoErro)): ?> <?php echo $modopreparoErro;?> <?php endif; ?>

<br/>

		<a href="index.php" class="btn btn-primary">Voltar</a>
		<button class="btn btn-success">Atualizar</button>
      </div>
    </div>
  </form>
</div>

</body>
</html>
