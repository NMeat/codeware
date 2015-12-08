<?php
//精美绝伦的代码
class stdObject{
	public function __construct(array $arguments = array()){
		if (!empty($arguments)) {
			foreach ($arguments as $property => $argument) {
				$this->{$property} = $argument;
			}
		}
	}

	public function __call($method, $arguments) {
        $arguments = array_merge(array("stdObject" => $this), $arguments);
        if (isset($this->{$method}) && is_callable($this->{$method})) {
            return call_user_func_array($this->{$method}, $arguments);
        } else {
            throw new Exception("Fatal error: Call to undefined method stdObject::{$method}()");
        }
    }
}

$obj = new stdObject();
$obj->name = "Nick";
$obj->surname = "Doe";
$obj->age = 20;
$obj->adresse = null;


$obj->getInfo = function($stdObject) {
    echo $stdObject->name . " " . $stdObject->surname . " have " . $stdObject->age . " yrs old. And live in " . $stdObject->adresse;
};
// $obj->getInfo();

$func = "setAge";
$obj->{$func} = function($stdObject, $age) {
    $stdObject->age = $age;
};

//$obj->setAge(24);

foreach ($obj as $func_name => $value) {
	if (!$value instanceOf Closure) {
		$obj->{"set" . ucfirst($func_name)} = function($stdObject, $value) use($func_name){
			$stdObject->{$func_name} = $value;
		};
		$obj->{"get" . ucfirst($func_name)} = function($stdObject) use($func_name){
			return $stdObject->{$func_name};
		};
	}
}

$obj->setName('lzf');
echo $obj->getName();