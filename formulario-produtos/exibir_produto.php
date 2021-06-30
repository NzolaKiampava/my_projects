<?php
	
	require 'classes/Produto_class.php';
	$p = new Produto_class('formulario_produtos', 'localhost', 'root', '');


	if (isset($_GET['id']) && !empty($_GET['id'])) 
	{
		$id = addslashes($_GET['id']);
		
	}
	else
	{
		header('location: produtos.php');
	}

	$dadosDoProduto = $p->buscarProdutosPorId($id);
	$imagensDoProduto = $p->buscarImagensPorId($id);  

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style>
		section{
			width: 70%;
			margin: auto;
			font-family: arial;
		}
		h1{
			color: rgba(0,0,0,.8);
			border-bottom: 1px solid rgba(0,0,0,.1);
			height: 60px;
			line-height: 70px;
			margin-bottom: 40px;
		}
		#imagens{
			background-color: red;
		}
		.caixa-img{
			width: 15%;
			float: left;
			padding: 1%;
			background-color: rgb(123,104,238,.4);
			margin: 10px;
			height: 150px;
			cursor: pointer;
		}
		img{
			width: 100%;
		}
		p{
			width: 70%;
			text-align: justify;
			line-height: 30px;
		}
	</style>
</head>
<body>
	<section>
		<div>
			<h1><?php echo $dadosDoProduto['nome_produto']; ?></h1>
			<p><b>Descrição: <?php echo $dadosDoProduto['descricao']; ?></b></p>
		</div>

		<?php
			foreach ($imagensDoProduto as $value) 
			{
				?>
				<div id="imagens">
					<div class="caixa-img">
						<img src="imagens/<?php echo $value['nome_imagem'];?>">
					</div>
				</div>
				<?php
			}
		?>
		
	</section>
</body>
</html>