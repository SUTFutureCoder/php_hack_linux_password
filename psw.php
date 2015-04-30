<?php
//请使用CLI模式并使用管理员用户运行

//只读模式打开/etc/shadow
$file = fopen('/etc/shadow', 'r');
//获取当前用户名
$current = get_current_user();


//探测是否到达$file文件末尾
while (!feof($file)){
    //按行读取$file
    $line = fgets($file);
    //按：分割数组
    $row = explode(':', $line);
    //当数组第一个元素等于当前用户名
    if ($row[0] == $current){
        //获取已加密内容
        $password_encrypted = $row[1];
    }
}
//关闭文件
fclose($file);

//获取加密后的盐值
$salt = substr($password_encrypted, stripos($password_encrypted, '$'), (strripos($password_encrypted, '$') - stripos($password_encrypted, '$') + 1));

//此处可以用密码字典代替
for ($i = 616000; $i < 700000; $i++){
    echo $i . PHP_EOL;
    //开始加密，碰撞
    $crypttext = crypt(strval($i), $salt); 
    //当碰撞值和加密后相等时
    if ($crypttext == $password_encrypted){
        //停止执行
        break;
    }
}
//输出密码
echo '密码是' . $i . PHP_EOL;







