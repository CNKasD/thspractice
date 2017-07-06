<?php

/**
 * 框架核心
 */
class Core
{
    protected $_config = [];

    public function __construct($config)
    {
        $this->_config = $config;
    }

    // 运行程序
    public function run()
    {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setReporting();
        $this->removeMagicQuotes();
        $this->setDbConfig();
        $this->route();
    }

    // 路由处理
    public function route()
    {
        $controllerName = $this->_config['defaultController'];
        $actionName = $this->_config['defaultAction'];
        $param = array();

        $url = $_SERVER['REQUEST_URI'];
        // echo $url . "<br />";

        $controllerName = isset($_GET['c']) ? $_GET['c'] : $this->_config['defaultController'];

        $actionName = isset($_GET['a']) ? $_GET['a'] : $this->_config['defaultAction'];

        $controllerName = ucfirst($controllerName);

        // 判断控制器和操作是否存在
        $controller = $controllerName . 'Controller';
        if (!class_exists($controller)) {
            exit($controller . '控制器不存在');
        }
        if (!method_exists($controller, $actionName)) {
            exit($actionName . '方法不存在');
        }

        //获取参数
        $params = $_SERVER['QUERY_STRING'];
        $params = explode('&', $params);
        $param = array();
        foreach ($params as $key => $value) {
            $tmp = explode('=', $value);
            if ($tmp[0]!='c' && $tmp[0]!='a') {
                $param["$tmp[0]"] = $tmp[1];
            }
        }
        //实例化控制器
        $dispatch = new $controller($controllerName, $actionName);

        // 调用控制器对应的方法
        call_user_func_array(array($dispatch, $actionName), $param);   //调用控制器下对应的方法
    }

    // 检测开发环境
    public function setReporting()
    {
        if ($this->_config['debug'] === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
        }
    }

    // 删除敏感字符函数
    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    // 检测敏感字符并删除
    public function removeMagicQuotes()
    {
        // if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        // }
    }


    // 配置数据库信息
    public function setDbConfig()
    {
        if ($this->_config['db']) {
            Model::$dbConfig = $this->_config['db'];
        }
    }

    // 自动加载控制器和模型类 
    public static function loadClass($class)
    {
        // echo $class . "<br />";
        //自动寻找使用了但未引用的类,$class参数就这么写
        $frameworks = __DIR__ . '/' . $class . '.class.php';
        $controllers = APP_PATH . 'application/controllers/' . $class . '.php';
        $models = APP_PATH . 'application/models/' . $class . '.php';

        if (file_exists($frameworks)) {
            // 加载框架核心类
            include $frameworks;
        } elseif (file_exists($controllers)) {
            // 加载应用控制器类
            include $controllers;
        } elseif (file_exists($models)) {
            //加载应用模型类
            include $models;
        } else {
            // 错误代码
        }
    }
}