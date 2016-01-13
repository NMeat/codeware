<?php 
class Amqp {
	public function __construct($prefix = array()){  
 		if($prefix){
 			//消息交换机，它指定消息按什么规则，路由到哪个队列
 			$this->amqp_exchang_name = $prefix['AMQP_EXCHANGE']; 	//交换机名
 			//消息队列载体，每个消息都会被投入到一个或多个队列 
			$this->amqp_queue_name   = $prefix['AMQP_QUEUE']; 		//队列名 
			$this->amqp_cache_key    = $prefix['AMQP_CACHE_KEY'] ; 	//路由key 
			$this->amqp_drug_key     = $prefix['AMQP_DRUG_KEY']; 	//路由key 
			
			$this->conn_args = array( 
				'host' 	   => $prefix['AMQP_HOST'],  
				'port' 	   => $prefix['AMQP_PORT'],  
				'login'    => $prefix['AMQP_USER'],  
				'password' => $prefix['AMQP_PWD'], 
				'vhost'    => $prefix['AMQP_VHOST']
			);	  
 		} else{
 			die('重要参数缺失!');
 		}
	}
	
	//发送信息
	public function sendTextMessage($msg,$key){
		//创建连接和channel 
		$conn = new AMQPConnection($this->conn_args); 
		if (!$conn->connect()) {    
			echo ("Cannot connect to the broker!\n");   
			return ;
		}     
		$channel = new AMQPChannel($conn);  

		//创建交换机    
		$ex = new AMQPExchange($channel);   
		$ex->setName($this->amqp_exchang_name); 
		$ex->setType(AMQP_EX_TYPE_DIRECT); //direct类型  
		$ex->setFlags(AMQP_DURABLE); //持久化 
		$ex->declare() ;   
		$ex->publish( $msg , $key) ;  					   
		$conn->disconnect();   
	}	 
}
