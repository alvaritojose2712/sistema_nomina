<?php    

require '../clases/websocket/vendor/autoload.php';
require '../conexion_bd.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface {
    protected $clients;
	private $logs;
    private $connectedUsers;
    private $connectedUsersNames;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->logs = [];
        $this->connectedUsers = [];
        $this->connectedUsersNames = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        echo "Nueva conexión! ({$conn->resourceId})\n";

        $this->connectedUsers [$conn->resourceId] = $conn;
        //$conn->send(json_encode($this->connectedUsers));

    }

    public function onMessage(ConnectionInterface $from, $msg) {
    	
        $arr_msg = json_decode($msg,true);
	    if (isset($arr_msg['de']) AND isset($arr_msg['para'])){
	        $de = $arr_msg['de'];
	        $para = $arr_msg['para'];

	        $values = "'".$de."','".$para."','".$arr_msg['msj']."'";
			$campos = "de, para, msj";
			if ($arr_msg['msj']!="--show_all--") {
				$insert = (new sql("mensajeria",$values,$campos))->insert();
			}
	        
	        $arr_send = array();

	        if ($arr_msg['msj']=="--show_all--") {
	        	$sql = (new sql("mensajeria","WHERE (de='".$de."' AND para='".$para."') OR (de='".$para."' AND para='".$de."') order by fecha asc"))->select();
	        	while($row = $sql->fetch_assoc()){
	        		array_push($arr_send, array("de"=>$row['de'], "para"=>$row['para'],"msj"=>$row['msj'],"fecha"=>$row['fecha']));
	        	}
	        	
	        }else{

	        	$sql = (new sql("mensajeria","WHERE (de='".$de."' AND para='".$para."') OR (de='".$para."' AND para='".$de."') order by fecha desc limit 1"))->select()->fetch_assoc();
	        	array_push($arr_send, array("de"=>$sql['de'], "para"=>$sql['para'],"msj"=>$sql['msj'],"fecha"=>$sql['fecha']));
	        }
	       // array_push($arr_send, array("de"=>"Usted es: ".$this->connectedUsers [$from->resourceId]['idUser'], "para"=>"","msj"=>"","fecha"=>""));
			$from->send(json_encode($arr_send));
			if ($arr_msg['msj']!="--show_all--") {
				foreach ($this->connectedUsers as $key => $value) {
					if ($value['idUser']==$arr_msg['para']) {
						$value['from']->send(json_encode($arr_send));
					}
				}
			}
			
			// if(isset($this->connectedUsers [$conn->resourceId][$arr_msg['para']])){
			// 	$this->connectedUsers [$conn->resourceId][$arr_msg['para']]->send(json_encode($arr_send));
			// }

		}elseif(isset($arr_msg['idUser'])){
			$this->connectedUsers [$from->resourceId] = array("from"=>$from,"idUser"=>$arr_msg['idUser']);
		}
    }

    public function onClose(ConnectionInterface $conn) {
        
        echo "Conexión {$conn->resourceId} se ha desconectado\n";
        $this->clients->detach($conn);
        unset($this->connectedUsersNames[$conn->resourceId]);
        unset($this->connectedUsers[$conn->resourceId]);
        
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Ha ocurrido un error: {$e->getMessage()}\n";

        $conn->close();
    }
}
	$server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Chat()
            )
        ),
        33006
    );

    $server->run();