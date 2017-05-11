<?php
class Model {
	//Variáveis para fazer a conexão com o banco de dados
	public $host = 'localhost';
	public $port = 7000;
	public $dbname = 'druida_db';
	public $username = 'root';
	public $password = 'digo00';
	public $db;
	/*
	public $host = 'localhost';
	public $port = 3306;
	public $dbname = 'u618565252_druid';
	public $username = 'u618565252_root';
	public $password = 'digo00';
	public $db;
	*/
	
	function __construct() {
		//Função que inicia o banco de dados usando PDO
		$this->db = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->dbname;charset=utf8mb4", $this->username, $this->password); 
	}
	
	function retornarProduto($idProduto) {
		$produto;
		$consulta = $this->db->prepare('SELECT * FROM produto WHERE id=:idProduto');
		$consulta->bindParam(':idProduto', $idProduto, PDO::PARAM_STR);
		$consulta->execute();
		while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
			$produto = $linha;
		}
		return ($produto);
	}
	
	//Retorna uma lista de produtos do banco de dados a partir de uma lista de IDs
	//O primeiro parâmetro é a lista de IDs.
	public function retornaProdutosDaLista($idProdutos) {
		$produtos = array();
		$consulta = $this->db->query('SELECT * FROM produto');
		//A iteração a seguir anda por cada um dos produtos no banco de dados e seleciona aqueles cujo id está contido no vetor $idProdutos.
		//Essa maneira não retornará itens repetidos e nem irá manter a ordem passada pelo vetor
		while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
			$id = $linha['id'];
			if (in_array($id, $idProdutos)) {
				$produtos[$linha['id']] = $linha;
			}
		}
		$produtosFinal = array();
		//A iteração a seguir irá criar um vetor de produtos com a ordem dos IDs e possíveis duplicatas.
		foreach($idProdutos as $id) {
			array_push($produtosFinal, $produtos[$id]);
		}
		return $produtosFinal;
	}
	
	//Retorna uma lista com produtos de uma $categoria
	public function retornarProdutosDaCategoria($categoria) {
		$produtos = array();
		//O comando abaixo prepara a consulta. Observe que no genero.nome = :parameter. Isso é feito para que possamos
		//passar uma variável para uma consulta sem que isso abra brecha pra SQL injections.
		$consulta = $this->db->prepare('SELECT produto.id AS id,
									produto.nome as nome,
									produto.qtd as qtd,
									produto.preco as preco,
									produto.img as img,
									genero.id as categoria_id,
									genero.nome as categoria_nome
							FROM produto
							JOIN genero
							JOIN produto_has_genero
							WHERE
								produto.id = produto_has_genero.produto_id &&
								genero.id = produto_has_genero.genero_id &&
	 							genero.nome = :parameter
							;');
		//Agora iremos associar o parâmetro a variável passada
		$consulta->bindParam(':parameter', $categoria, PDO::PARAM_STR);
		//E então executaremos a query.
		$consulta->execute();
		while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
			array_push($produtos, $linha);
		}
		return ($produtos);
	}
	//Exemplo de uso da função acima:
	//retornaProdutosDaCategoria("Cosméticos");
	
	public function cadastrarUsuario($nome, $login, $senha, $email) {
		$query = $this->db->prepare('INSERT INTO usuarios (nome, login, senha, email)
									VALUES (:nome, :login, :senha, :email)');
		$query->bindParam(':nome', $nome, PDO::PARAM_STR);
		$query->bindParam(':login', $login, PDO::PARAM_STR);
		$query->bindParam(':senha', $senha, PDO::PARAM_STR);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$resultado = $query->execute();
		return $resultado;
	}
	
	public function acessarUsuario($login, $senha) {
		$query = $this->db->prepare('SELECT * FROM usuarios
									WHERE login=:login AND senha=:senha');
		$query->bindParam(':login', $login, PDO::PARAM_STR);
		$query->bindParam(':senha', $senha, PDO::PARAM_STR);
		$query->execute();
		
		//Variável que irá armazenar as informações do usuário na BD, ou que será NULL caso o login não tenha sucesso.
		$resultado;
		while ($linha = $query->fetch(PDO::FETCH_ASSOC)) {
			$resultado =  $linha;
		}
		
		return $resultado;
	}
	
	//Relativo ao admin
	public function acessarAdmin($login, $senha) {
		$query = $this->db->prepare('SELECT * FROM admin
									WHERE login=:login AND senha=:senha');
		$query->bindParam(':login', $login, PDO::PARAM_STR);
		$query->bindParam(':senha', $senha, PDO::PARAM_STR);
		$query->execute();
	
		//Variável que irá armazenar as informações do usuário na BD, ou que será NULL caso o login não tenha sucesso.
		$resultado;
		while ($linha = $query->fetch(PDO::FETCH_ASSOC)) {
			$resultado =  $linha;
		}
	
		return $resultado;
	}
	
	public function cadastrarProduto($nome, $preco, $qtd, $img, $categorias) {
		//Inserir o produto na tabela produto
		$query = $this->db->prepare('INSERT INTO produto (nome, preco, qtd, img)
									VALUES (:nome, :preco, :qtd, :img)');
		$query->bindParam(':nome', $nome, PDO::PARAM_STR);
		$query->bindParam(':preco', $preco, PDO::PARAM_STR);
		$query->bindParam(':qtd', $qtd, PDO::PARAM_STR);
		$query->bindParam(':img', $img, PDO::PARAM_STR);
		$query->execute();
		
		//Pegar o id do produto inserido, não consegui fazer com o SELECT LAST_INSERT_ID()
		$query = $this->db->prepare('SELECT * FROM produto
									WHERE nome=:nome');
		$query->bindParam(':nome', $nome, PDO::PARAM_STR);
		$query->execute();
		$produto;
		while ($linha = $query->fetch(PDO::FETCH_ASSOC)) {
			$produto =  $linha;
		}
		$produto_id = $produto['id'];
		
		//Adicionar na tabela 
		foreach($categorias as $genero_id) {
			$query = $this->db->prepare('INSERT INTO produto_has_genero (produto_id, genero_id)
									VALUES (:produto_id, :genero_id)');
			$query->bindParam(':produto_id', $produto_id, PDO::PARAM_STR);
			$query->bindParam(':genero_id', $genero_id, PDO::PARAM_STR);
			$resultado = $query->execute();
		}
		
		return $resultado;
	}
	
	public function retornarCategorias() {
		$query = $this->db->prepare('SELECT * FROM genero');
		$query->execute();
		
		$resultado = array();
		while ($linha = $query->fetch(PDO::FETCH_ASSOC)) {
			array_push($resultado, $linha);
		}
		return $resultado;
	}
}

// Essa classe será usada apenas para armazenar um produto
// quando for para o carrinho de compras
class Produto{
	public $id;
	public $nome;
	public $preco;
	
	function __construct($id, $nome, $preco) {
		$this->id = $id;
		$this->nome = $nome;
		$this->qtd = $qtd;
		$this->preco = $preco;
	}
}

class Usuario{
	private $id;
	private $nome;
	private $login;
	private $senha;
	private $email;
	//Esse array mantém um id do produto e sua quantidade
	private $carrinho = array();

	function __construct($id, $nome, $login, $senha, $email) {
		$this->id = $id;
		$this->nome = $nome;
		$this->login = $login;
		$this->senha = $senha;
		$this->email = $email;
	}
	
	
	
}
