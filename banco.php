<?php
class Banco {
    private static $dbNome = 'cozinha';
    private static $dbHost = 'localhost';
    private static $dbUsuario = 'root';
    private static $dbSenha = '';
    private static $cont = null;
    
    public function __construct() {
        die('A função Init nao é permitido!');
    }
    
    public static function conectar() {
        if(null == self::$cont) {
            try {
                self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbNome, self::$dbUsuario, self::$dbSenha); 
            }
            catch(PDOException $exception) {
                die($exception->getMessage());
            }
        }
        return self::$cont;
    }
    public static function desconectar() {
        self::$cont = null;
    }
}

$item = "</li>
<br/>
<li>";

function rodape() {
?>
<footer class="footer container">
	<table class="table text-center">
		<thead>
			<tr>
				<td>SEU NOME<br/>(XX)XXXX-XXXX</td>
			</tr>
		</thead>
	</table>
</footer>

<?php
}
?>
