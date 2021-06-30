<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<style type="text/css">
	section{
		width: 70%;
		margin: auto;
		font-family: arial;
	}
	div{
		width: 15%;
		float: left;
		padding: 1%;
		background-color: rgb(123,104,238,.4);
		margin: 10px;
	}
	img{
		width: 100%;
		height: 150px;
	}

	h2{
		font-size: 12pt;
		color: white;
		text-align: center;
		background-color: rgba(0,0,0,.5);
		padding: 10px 0px;
		font-weight: normal;
	}
	p{
		font-size: 10pt;
	}
	</style>
</head>
<body>
	<section>
		<?php
			require 'classes/Produto_class.php';
			$p = new Produto_class('formulario_produtos','localhost','root','');

			$dadosProduto = $p->buscarProdutos();

			if (empty($dadosProduto)) {
				
				echo "Ainda não há produto cadastrado!";
			}
			else
			{	
				for ($i=0; $i < count($dadosProduto) ; $i++) 
				{ 
					?>
					<a href="exibir_produto.php?id=<?php echo $dadosProduto[$i]['id_produto'];?>">
						<div>
							<img src="imagens/<?php echo $dadosProduto[$i]['foto_capa'];?>">
							<h2><?php echo $dadosProduto[$i]['nome_produto'];?></h2>
						</div>
					</a>
					<?php
				}

				//ou tambem podemo utilizar um foreach
				/*
				foreach ($dadosProduto as $value) 
				{
					
					?>
					<a href="exibir_produto.php?id=<?php echo $dadosProduto['id_produto']?>">
						<div>
							<img src="imagens/<?php echo $value['foto_capa'];?>">
							<h2><?php echo $value['nome_produto'];?></h2>
						</div>
					</a>
					<?php
				}
				*/
				
			}
		?>
		
	</section>
</body>
</html>