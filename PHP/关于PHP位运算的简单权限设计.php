<?php
/**
 * 简单权限类 (转)
 * @author 27_Man
 */
class Peak_Auth {

    /**
     * 权限类计数器
     * 作用在于生成权限值
     *
     * @var int
     */
    protected static $authCount = 0;

    /**
     * 权限名称
     *
     * @var string
     */
    protected $authName;

    /**
     * 权限详细信息
     *
     * @var string
     */
    protected $authMessage;

    /**
     * 权限值
     *
     * @var int 2的N次方
     */
    protected $authValue;

    /**
     * 构造函数
     * 初始化权限名称、权限详细信息以及权限值
     *
     * @param string $authName 权限名称
     * @param string $authMessage 权限详细信息
     */
    public function __construct($authName, $authMessage = '') {
        $this->authName = $authName;
        $this->authMessage = $authMessage;
        $this->authValue = 1 << self::$authCount;// 表示1 向左移的位数
        self::$authCount++;
    }

    /**
     * 本类不允许对象复制操作
     */
    private function __clone() {
        
    }

    /**
     * 设置权限详细信息
     *
     * @param string $authMessage
     */
    public function setAuthMessage($authMessage) {
        $this->authMessage = $authMessage;
    }

    /**
     * 获取权限名称
     *
     * @return string
     */
    public function getAuthName() {
        return $this->authName;
    }

    /**
     * 获取权限值
     *
     * @return int
     */
    public function getAuthValue() {
        return $this->authValue;
    }

    /**
     * 获取权限详细信息
     *
     * @return string
     */
    public function getAuthMessage() {
        return $this->authMessage;
    }
}



/**
 * 简单角色类
 *
 * @author 27_Man
 */
class Peak_Role {

    /**
     * 角色名
     *
     * @var string
     */
    protected $roleName;

    /**
     * 角色拥有的权限值
     *
     * @var int
     */
    protected $authValue;

    /**
     * 父角色对象
     *
     * @var Peak_Role
     */
    protected $parentRole;

    /**
     * 构造函数
     *
     * @param string $roleName 角色名
     * @param Peak_Role $parentRole 父角色对象
     */
    public function __construct($roleName, Peak_Role $parentRole = null) {
        $this->roleName = $roleName;
        $this->authValue = 0;
        if ($parentRole) {
            $this->parentRole = $parentRole;
            $this->authValue = $parentRole->getAuthValue();
        }
    }

    /**
     * 获取父角色的权限
     */
    protected function fetchParenAuthValue() {
        if ($this->parentRole) {
            $this->authValue |= $this->parentRole->getAuthValue();
        }
    }

    /**
     * 给予某种权限
     *
     * @param Peak_Auth $auth
     * @return Peak_Role 以便链式操作
     */
    public function allow(Peak_Auth $auth) {
        $this->fetchParenAuthValue();
        $this->authValue |=  $auth->getAuthValue();
        return $this;
    }

    /**
     * 阻止某种权限
     *
     * @param Peak_Auth $auth
     * @return Peak_Role 以便链式操作
     */
    public function deny(Peak_Auth $auth) {
        $this->fetchParenAuthValue();
        $this->authValue &= ~$auth->getAuthValue();
        return $this;
    }

    /**
     * 检测是否拥有某种权限
     *
     * @param Peak_Auth $auth
     * @return boolean
     */
    public function checkAuth(Peak_Auth $auth) {
        return $this->authValue & $auth->getAuthValue();
    }

    /**
     * 获取角色的权限值
     *
     * @return int
     */
    public function getAuthValue() {
        return $this->authValue;
    }
}
// 创建三个权限：可读、可写、可执行
$read  = new Peak_Auth('CanRead');  //$authCount = 1; $authValue = 1
$write = new Peak_Auth('CanWrite'); //$authCount = 2; $authValue = 2;
$exe   = new Peak_Auth('CanExe');   //$authCount = 3; $authValue = 4;

// 创建一个角色 User
$user = new Peak_Role('User');

// 创建另一个角色 Admin，他拥有 User 的所有权限
$admin = new Peak_Role('Admin', $user);

// 给予 User 可读、可写的权限
$user->allow($read)->allow($write);

// 给予 Admin 可执行的权限，另外他还拥有 User 的权限
$admin->allow($exe);

// 禁止 Admin 的可写权限
$admin->deny($write);

// 检测 Admin 是否具有 某种权限
var_dump($admin->checkAuth($read));
var_dump($admin->checkAuth($write));
var_dump($admin->checkAuth($exe));