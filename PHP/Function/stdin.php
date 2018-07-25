<?php
/**
 *  PHP语言中"STDIN"用于从控制台读取内容。
 *  遇到此常量或者通过fopen()函数打开php://stdin脚本将会等待用户输入内容，直到用户按下回车键提交。
 */

echo '请输入内容:';
$msg = fgets(STDIN);
echo sprintf("输入的内容为: %s\n", $msg);

$stdInHandle = fopen('php://stdin', 'r');
echo '请输入内容:';
$msg = fread($stdInHandle, 12); //最多读取12个字符
echo sprintf("输入的内容为: %s\n", $msg);
fclose($stdInHandle);

/**
 *PHP语言中STDOUT用于向控制台输出标准信息。
 *向此常量、或者向fopen()函数打开的php://stdout写入的内容将直接输出到控制台的标准输出。
 */

fwrite(STDOUT, "通过STDOUT写入;\n");
$stdOutHandle = fopen('php://stdout', 'w');
fwrite($stdOutHandle, "通过php://stdout写入;\n\n");
fclose($stdOutHandle);

/**
 *PHP语言中"STDERR"用于向控制台输出错误信息。
 *向常量、或者向fopen()函数打开的"php://stderr"写入的内容将直接输出到控制台的错误输出。
 *
 */
fwrite(STDERR, "STDERR写入的错误输出;\n");
fwrite(STDOUT, "STDOUT写入的正常输出;\n");

$stdout = fopen("php://stdout", "w");
fwrite($stdout, "php://stdout写入的正常输出；\n");
fclose($stdout);

$stderr = fopen("php://stderr", "w");
fwrite($stderr, "php://stderr写入的错误输出；\n");
fclose($stderr);

