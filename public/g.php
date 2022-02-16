<?php
$filename = '7ipv6.txt';
phpinfo();

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


function saveVar($name,$v){
    $myfile = fopen("7ipv6.txt", "r") or die("Unable to open file!1");
    $all='';
    $flag=true;
    $key = $name.':';
    while(!feof($myfile)) {
        $li = trim(fgets($myfile));
        if(strlen($li)>1){
            if(startsWith($li,$key)){
                $all.=$name.':'.$v.PHP_EOL;
                $flag=false;
            }else{
                $all.=$li.PHP_EOL;
            }
        }
    }
    if($flag){
        $all.=$name.':'.$v.PHP_EOL;
    }
    if($name=='null'){
        $all='';
    }
    fclose($myfile);
    $myfile = fopen("7ipv6.txt", "w") or die("Unable to open file!2");
    fwrite($myfile, $all);
    fclose($myfile);
}

function showVar($v){
    $myfile = fopen("7ipv6.txt", "r") or die("Unable to open file!3");
    $key = $v.':';
    while(!feof($myfile)) {
        $li = fgets($myfile);
        if(startsWith($li,$key)){
            echo($li);
        }
    }
    fclose($myfile);
}

function goVar($v){
    $myfile = fopen("7ipv6.txt", "r") or die("Unable to open file!4");
    $key = $v.':';
    while(!feof($myfile)) {
        $li = fgets($myfile);
        if(startsWith($li,$key)){
            echo($li);
			$newURL = substr($li, strlen($key));
			header('Location: '.'http://'.$newURL);
        }
    }
    fclose($myfile);
}

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}


$name='ip';
if(!empty($_GET['name']) and !empty($_GET['value']) and !empty($_GET['check'])){
    $name=$_GET['name'];
    $value=$_GET['value'];
    $check=$_GET['check'];
    if(md5($name.'t'.$value)==$check){
        saveVar($name,$value);
        echo($name.':'.$value);
    }
}else{
    if(!empty($_GET['go'])){
        $ip = $_GET['go'];
        goVar($ip);
    }
    else{
        echo(get_client_ip());
    }
}

?>