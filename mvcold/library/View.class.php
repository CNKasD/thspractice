<?php
/**
 * 视图基类
 */
class View
{
    // protected $variables = array();
    protected $_controller;

    function __construct($controller, $action)
    {
        $this->_controller = strtolower($controller);
        $this->_action = strtolower($action);
    }
 

    //渲染视图
    public function view($layout,$params)
    {
        extract($params);  //将数组根据键名提取为变量
        $defaultHeader = APP_PATH . 'application/views/header.php';
        $defaultFooter = APP_PATH . 'application/views/footer.php';

        $controllerHeader = APP_PATH . 'application/views/' . $this->_controller . '/header.php';
        $controllerFooter = APP_PATH . 'application/views/' . $this->_controller . '/footer.php';
        $controllerLayout = APP_PATH . 'application/views/' . $this->_controller . '/' . $layout . '.php';

        // 页头文件
        if (file_exists($controllerHeader)) {
            include ($controllerHeader);
        } else {
            include ($defaultHeader);
        }

        //页面主要内容
        if (file_exists($controllerLayout)) {
            include ($controllerLayout);
        } else {
            die('视图文件不存在');
        }

        // 页脚文件
        if (file_exists($controllerFooter)) {
            include ($controllerFooter);
        } else {
            include ($defaultFooter);
        }
    }
}