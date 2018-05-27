<?php
// 服务器500错误记录
function sys_user_parse_error () {
    $e = error_get_last();
    $errortype = array(
        E_ERROR,
        E_PARSE,
        E_USER_ERROR,
        E_COMPILE_ERROR,
        E_CORE_ERROR,
        E_RECOVERABLE_ERROR,
    );
    if($e && in_array($e['type'], $errortype)) {
        if(class_exists('Logger')){
            $file = explode(DIRECTORY_SEPARATOR, $e['file']);
            $file = end($file);
            Logger::logError(sprintf("%s,%s,error=%s", $file, $e['line'], var_export($e, true)), 'user_error_parse');
        }
    }
}
register_shutdown_function("sys_user_parse_error");
