<?php
	
class Produto_class
{
	private $pdo;

	public function __construct($dbname, $host, $user, $senha)
	{
		try
		{
			$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
		}
		catch(PDOException $e)
		{
			echo "Erro com base de dados: ".$e->getMessage();
		}
		catch(Exception $e)
		{
			echo "Erro generico: ".$e->getMessage();
		}
	}

	public function enviarProdutos($nome, $descricao, $fotos = array()) //array, caso o usuario nao selecionar imagem, deste geito ira apresentar array vazio
	{

		//INSERINDO OS PRODUTOS(TABELA PRODUTOS)
		$cmd = $this->pdo->prepare('INSERT INTO produtos(nome_produto, descricao)values(:n, :d)');

		$cmd->bindValue(':n', $nome);
		$cmd->bindValue(':d', $descricao);
		$cmd->execute();

		// na tabela imagens temos uma coluna chamado fk_id_produto(chave estrangeira), ou seja pra inserir uma imagem eu preciso saber a q produto essa imagens pertencem. E como vamos fazer isso se eu acabei de inserir o produto ou acabou de ser gerado um id, como q vamos pegar este id?R: Para isso existe uma funcao LastInsertId, q estamos utilizando em baixo: 

		$id_produto = $this->pdo->LastInsertId();

		//INSERINDO AS IMAGENS(TABELA IMAGENS)

		if (count($fotos) > 0)    //se veio imagens
		{
			for ($i=0; $i < count($fotos); $i++) 
			{
				$nome_foto = $fotos[$i];

				$cmd = $this->pdo->prepare('INSERT INTO imagens (nome_imagem, fk_id_produto)VALUES(:n, :fk)');

				$cmd->bindValue(':n', $nome_foto);
				$cmd->bindvalue(':fk', $id_produto);
				$cmd->execute();
			}
		}
	}

	public function buscarProdutos() //Todos os produtos
	{	
		$cmd = $this->pdo->query('SELECT *,(SELECT nome_imagem FROM imagens WHERE fk_id_produto = produtos.id_produto LIMIT 1) as foto_capa FROM produtos');

		if ($cmd->rowCount() > 0) 
		{
			$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);

		}else
		{
			$dados = array();
		}
		return $dados;
		
	}

	public function buscarProdutosPorId($id)  //1 produto
	{	
		$cmd = $this->pdo->prepare('SELECT nome_produto, descricao FROM produtos where id_produto = :id');
		$cmd->bindValue(':id', $id);
		$cmd->execute();

		if ($cmd->rowCount() > 0) 
		{
			
			$dados = $cmd->fetch();
		}
		else
		{
			$dados = array();
		}

		return $dados;
	}

	public function buscarImagensPorId($id)  //buscando todas as imagens
	{
		$cmd = $this->pdo->prepare('SELECT * FROM imagens where fk_id_produto = :id');
		$cmd->bindValue(':id', $id);
		$cmd->execute();

		if ($cmd->rowCount() > 0) 
		{
			
			$dados = $cmd->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			$dados = array();
		}

		return $dados;
	}
}



?>