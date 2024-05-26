<?php

require_once './includes/session.php';
require_once '../database/credentials.php';
require_once '../database/db_connection.php';

if(!isset($_SESSION['id_estabelecimento']) || !isset($_SESSION['nome']) || !isset($_SESSION['authenticatedB'])) {
    header("Location: /Business/dashboard_home_page.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: /Business/dashboard_home_page.php");
}

$json = json_decode(file_get_contents('php://input'),true);

$data = [
    "idEstabelecimento" => $json['idEstabelecimento'], 
    "tipo" => $json['tipo'], 
    "dados" => $json['dados'],
 ]; 

if($data['idEstabelecimento'] != $_SESSION['id_estabelecimento']){
    exit("you cant add items to other stores!");
}

try{
    $item = ItemFactory::createItem($data['tipo'],$data['dados']);
    $item->createDatabaseEntry();

    $status = 'success';
    $message = 'Item inserido com sucesso';
} catch (Exception $e) {
    $status = 'error';
    $message = $e;
}

header('Content-type: application/json');
print_r(json_encode(getReturnMessage($status,$message)));

function getReturnMessage($status,$message){
    return ["status" => $status, "message" => $message];
}

class ItemFactory{
    static function createItem($tipo,$dados){
        $item = null;
        switch($tipo){
            case 'item':
                $item = new SingleItem($dados['nome'],$dados['preco'],$dados['descricao'],$dados['disponivel'],$dados['foto'],$dados['categoria']);
            break;
            case 'item-personalizado':
                $item = new ItemPersonalized($dados['nome'],$dados['preco'],$dados['descricao'],$dados['disponivel'],$dados['foto'],$dados['categoria'],$dados['opcoes']);
            break;
            case 'bundle': 
                $item = new Bundle($dados['nome'],$dados['preco'],$dados['descricao'],$dados['disponivel'],$dados['foto'],$dados['categoria'],$dados['itens']);
            break;
            default:
                throw new Exception('Invalid Object');
        }
        return $item;
    }
}

abstract class AbstractItem {
    public string $nome;
    public string $descricao;
    public float $preco;
    public bool $disponivel;
    public string $foto;
    public string $categoria;
    public int $item_id;

    public function __construct($nome,$preco,$descricao,$disponivel,$foto,$categoria,$item_id = null,) {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->descricao = $descricao;
        $this->disponivel = $disponivel == "true" ? true:false;
        $this->foto = $foto;
        $this->categoria = $categoria;

        if($item_id != null){
            $this->item_id = $this->getItemId();
        }
    }
    abstract function createDatabaseEntry();

    protected function checkExistence(){
        global $pdo;

        $stmt = $pdo->prepare("SELECT count(*)
        FROM public.itens where nome = ? and preco = ? and foto = ?;");
        $stmt->execute([$this->nome,$this->preco,$this->foto]);
        $count = $stmt->fetchColumn();
    
        return $count > 0;
    }

    protected function getItemId(){
        global $pdo;

        $id_query = "SELECT
        id_item FROM ITENS 
        where nome = ? 
        and preco = ? and descricao = ? 
        and disponivel = ? and foto = ? 
        and id_categoria = ? and id_estabelecimento = ?";

        $stmt = $pdo->prepare($id_query);
        $stmt->execute([
            $this->nome,$this->preco,
            $this->descricao,$this->disponivel,
            $this->foto, $this->categoria, $_SESSION['id_estabelecimento']]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['id_item'];
    }
}


class SingleItem extends AbstractItem {

    public function __construct($nome,$preco,$descricao,$disponivel,$foto,$categoria) {
        parent::__construct($nome,$preco,$descricao,$disponivel,$foto,$categoria);
    }

    /**
     */
    public function createDatabaseEntry() {
        global $pdo;
        global $idEmpresa;

        if ($this->checkExistence() == false) {
            $query = "INSERT INTO itens(
                nome, preco,
                descricao, disponivel, foto,
                itemsozinho, personalizacoesativas,
                id_categoria, id_estabelecimento) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($query);
            $response = 
            $stmt->execute([
            $this->nome,$this->preco,
            $this->descricao,$this->disponivel ? 1:0,
            $this->foto,1, 0,
            $this->categoria, $_SESSION['id_estabelecimento']]);
    
            if($response == false)
                throw new Exception("Não foi possivel efetuar a operação");
        }
    }
}

class ItemPersonalized extends AbstractItem {
    var $options=array();
    var $id_item;
    public function __construct($nome,$preco,$descricao,$disponivel,$foto,$categoria,$opcoes) {
        parent::__construct($nome,$preco,$descricao,$disponivel,$foto,$categoria);

        foreach($opcoes as $op){
            $option = new Opcao($op['nome'],$op['preco'],$op['max_quantidade']);
            array_push($this->options,$option);
        }
    }
    /**
     */
    function createDatabaseEntry() {
        global $pdo;
        global $idEmpresa;

        if ($this->checkExistence() == false) {
            $query = "INSERT INTO itens(
                nome, preco,
                descricao, disponivel, foto,
                itemsozinho, personalizacoesativas,
                id_categoria, id_estabelecimento) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
            $stmt = $pdo->prepare($query);
            $stmt->execute([
            $this->nome,$this->preco,
            $this->descricao,$this->disponivel == "true" ? 1:0 ,
            $this->foto,1, 1,
            $this->categoria, $_SESSION['id_estabelecimento']]);
        }

        $this->id_item = $this->getItemId();

        foreach($this->options as $option){
            $this->createOptionEntry($option);
        }
    }

    private function createOptionEntry($option){
        global $pdo;
        global $idEmpresa;

        if($this->id_item == null){
            $this->id_item = $this->getItemId();
        }

        if($this->checkOptionExistence($option,$this->id_item) == true){
            return;
        }

        $query = 
        "INSERT INTO opcoes
            (nome, max_quantidade, preco, id_item)
            VALUES ( ?, ?, ?, ?);";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
        $option->nome,$option->max_quantidade,
        $option->preco,$this->id_item]);
    }


    function checkOptionExistence($option,$id_item){
        global $pdo;

        $stmt = $pdo->prepare("SELECT count(*)
        FROM public.opcoes where nome = ? and max_quantidade = ? and preco = ? and id_item = ?;");
        $stmt->execute([$option->nome,$option->max_quantidade,$option->preco,$option->id_item]);
        $count = $stmt->fetchColumn();
    
        return $count > 0;
    }
}

class Bundle extends AbstractItem {
    var $itens = array();
    public function __construct($nome,$preco,$descricao,$disponivel,$foto,$categoria,$itens) {
        parent::__construct($nome,$preco,$descricao,$disponivel,$foto,$categoria);
        foreach($itens as $item){
            $option = new Opcao($item['nome'],$item['preco'],$item['max_quantidade']);
            array_push($this->itens,$option);
        }
    }
    /**
     */
    public function createDatabaseEntry() {
        global $pdo;
        global $idEmpresa;

        if ($this->checkExistence() == true) {
            exit("Esse item já existe!");
        }

        $stmt = $pdo->prepare("INSERT INTO categorias(nome, id_empresa) VALUES (?, ?);");
        $stmt->execute([$_POST["category-input"],$idEmpresa]);
        header('Location: /business/dashboard_lista_categorias.php');
    }
}


class Opcao {
    public string $nome;
    public float $preco;
    public float $max_quantidade;
    public int $option_id;
    public int $id_item;

    public function __construct($nome,$preco,$max_quantidade,$id_item = -1) {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->max_quantidade = $max_quantidade;
        $this->id_item = $id_item;

        if($id_item != -1){
            $this->option_id = $this->getId();
        }
    }

    function getId(){
        global $pdo;

        $id_query = "SELECT id_opcao FROM opcoes 
        where nome = ? and max_quantidade = ? 
        and preco = ?";

        $stmt = $pdo->prepare($id_query);
        $stmt->execute([
            $this->nome,$this->max_quantidade,
            $this->preco]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['id_opcao'];
    }
}