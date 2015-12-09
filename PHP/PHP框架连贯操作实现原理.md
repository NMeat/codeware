**php框架--php框架的连贯查询实现原理**

方法1：
    class sql{
    	private $sql=array("from"=>"",
    			"where"=>"",
    			"order"=>"",
    			"limit"=>"");
   
    	public function from($tableName) {
    		$this->sql["from"]="FROM ".$tableName;
    		return $this;
    	}
     
    	public function where($_where='1=1') {
    		$this->sql["where"]="WHERE ".$_where;
    		return $this;
    	}
     
    	public function order($_order='id DESC') {
    		$this->sql["order"]="ORDER BY ".$_order;
    		return $this;
    	}
     
    	public function limit($_limit='30') {
    		$this->sql["limit"]="LIMIT 0,".$_limit;
    		return $this;
    	}
    	public function select($_select='*') {
    		return "SELECT ".$_select." ".(implode(" ",$this->sql));
    	}
    }
     
    $sql =new sql();
    echo $sql->from("testTable")->where("id=1")->order("id DESC")->limit(10)->select();
    //输出 SELECT * FROM testTable WHERE id=1 ORDER BY id DESC LIMIT 0,10

方法2:
 
    class Users  
    {  
	    protected $options = array();
	    public function select()  
	    {  
		    $fields = $this->options['field'] ? $this->options['field'] : "*";  
		    $query = "select ".$fields." from ";  
		    $query .= $this->options['table']." where ";  
		    $query .= $this->options['where']." limit 0,";  
		    $query .= $this->options['limit']." order by ";  
		    $query .= $this->options['order'].";";;  
		    echo $query;  
		    //do something for select data from database;  
	    }
		//魔术方法  
	    public function __call($methods,$vars)  
	    {  
		    $this->options[$methods] = $vars[0];  
		    return $this;   //关键在这里是返回对象  
    	}  
    }  
    $p = new Users();
    $p->table('users')->field('username,passwd')->where("uid = 12")->limit('10')->order("uid asc")->select();