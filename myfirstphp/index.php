<?php
//phpinfo() ;die;
echo "hello php world!</br>";
echo date("Y:m:d H:i:s");
echo "</br>";
global $x;
$y = 10;

/**
 *myTest()方法
 */
function myTest()
{
    $x = 5;
    global $x, $y, $xzz;
    $xzz = $x + $y;
    echo $xzz;
}
echo ("<hr>");
myTest();
echo "</br>";
//echo $xzz;
/**
 * testStatic()
 */
echo "<hr>";

$x1 = 1;
function testStatic($yy)
{
    static $x1 = 0;
    echo $yy;
    $x1++;
}

testStatic(55);
testStatic(55);
testStatic(55);
echo ("<hr>");
echo $x1;
echo "<h2>PHP 很有趣!</h2>";
echo "Hello world!<br>";
echo "我要学 PHP!<br>";
echo "这是一个", "字符串，", "使用了", "多个", "参数。";
echo ("<hr>");
$txt1 = "学习 PHP";
$txt2 = "RUNOOB.COM";
$cars = array("Volvo", "BMW", "Toyota");

echo "<h2>$txt1</h2>";
echo "<br>";
echo "在 {$txt2} 学习 PHP ";
echo "<br>";
echo "我车的品牌是 {$cars[1]}";

print "<h2>PHP 很有趣!</h2>";
print "Hello world!<br>";
print "我要学习 PHP!";

echo ("<hr>");
$x = 015125;
var_dump($x);
echo "<br>";
$x = -345; // 负数
var_dump($x);
echo "<br>";
$x = 0x8C; // 十六进制数
var_dump($x);
echo "<br>";
$x = 01000047; // 八进制数
var_dump($x);

echo "<hr>";
$x = 10.365;
var_dump($x);
echo "<br>";
$x = 2.4e3;
var_dump($x);
echo "<br>";
$x = 8E-5;
var_dump($x);
echo "<hr>";
$x=true;
$y=false;
echo $x;
print $x;
echo "<hr>";
$cars=array("Volvo","BMW","Toyota");
var_dump($cars);
echo "<hr>";
class Car{
    var $color;
    function  Car($color="green"){
        $this->color=$color;
    }
    function what_color(){
        return $this->color;
    }
}
function print_vars($obj){
    foreach (get_object_vars($obj) as $prop=>$val){
        echo "--$prop=$val\n";
    }
}
//创建一个对象
$herbie = new Car("123");
//输出属性
echo "\herbie: Properties\n";
print_vars($herbie);

echo "<hr>";
$x="Hello world!";
$x=null;
var_dump($x);
echo "<hr>";
// 区分大小写的常量名
define("GR", "欢迎访问 Runoob.com",true);
echo GR;    // 输出 "欢迎访问 Runoob.com"
echo '<br>';
echo gr;   // 输出 "greeting"
echo "<hr>";
define("GREETING","欢迎访问juzhen.com");
function myteat(){
    echo GREETING;
}
myteat();
echo "<hr>";
$txt1="Hello world!";
$txt2="What a nice day!";
echo $txt1 . " " . $txt2;
echo "<hr>";
echo strlen($txt1);
echo strlen("中文字符好");   // 输出 15
echo mb_strlen("中文字符好",'utf-8');  // 输出 5
echo "<hr>";
$a = "Hello";
$b = $a . " world!";
echo $b; // 输出Hello world!

$x="Hello";
$x .= " world!";
echo $x; // 输出Hello world!
echo "<hr>";
$x=10;
echo ++$x; // 输出11

$y=10;
echo $y++; // 输出10

$z=5;
echo --$z; // 输出4

$i=5;
echo $i--; // 输出5
echo "<hr>";
$x=100;
$y="100";

var_dump($x == $y);
echo "<br>";
var_dump($x === $y);
echo "<br>";
var_dump($x != $y);
echo "<br>";
var_dump($x !== $y);
echo "<br>";

$a=50;
$b=90;
var_dump($a > $b);
echo "<br>";
var_dump($a < $b);

echo "<hr>";
$x = array("a" => "red", "b" => "green");
var_dump($x);echo "<br>";
$y = array("c" => "blue", "d" => "yellow");
var_dump($y);echo "<br>";
$z = $x + $y; // $x 和 $y 数组合并
var_dump($z);echo "<br>";
var_dump($x == $y);
var_dump($x === $y);
var_dump($x != $y);
var_dump($x <> $y);
var_dump($x !== $y);
echo "<hr>";
$test = 123;
// 普通写法
$username = isset($test) ? $test : 'nobody1';
echo $username, PHP_EOL;
$username = empty($test) ? $test : 'nobody1';
echo $username, PHP_EOL;
// PHP 5.3+ 版本写法
$username = $test ?: 'nobody2';
echo $username, PHP_EOL;
echo "<hr>";
$t=date("H");
echo $t;
if($t<10){
    echo "Have a good morning!";
}elseif ($t<20){
    echo "have a goood moring!";
}else{
    echo "have a good night";
}

echo "<hr>";
$favcolor="red1";
switch ($favcolor)
{
    case "red":
        echo "你喜欢的颜色是红色!";
        break;
    case "blue":
        echo "你喜欢的颜色是蓝色!";
        break;
    case "green":
        echo "你喜欢的颜色是绿色!";
        break;
    default:
        echo "你喜欢的颜色不是 红, 蓝, 或绿色!";
}
echo "<hr>";
$x='b';
switch ($x){
    case 'a':                      //变量$x的值和该种情况匹配，将从此处开始执行。
        echo "这里是a"."<br>";
        break;
    case 'b':
        echo "这里是b"."<br>";
        break;
    case 'c':
        echo "这里是c"."<br>";
        break;
    default:
        echo "这里是default";
}

echo "<hr>";
$cars=array("bob","bmw","toy");
echo var_dump($cars);
echo "I like " . $cars[0] .", ".$cars[1];
echo "<hr>";
$cars=array("Volvo","BMW","Toyota");
$arrlength=count($cars);
for($x=0;$x<$arrlength;$x++)
{
    echo $cars[$x];
    echo "<br>";
}
echo "<hr>";
$age=array("peter"=>"23","Ben"=>"37","Joe"=>"43");
echo "Peter is " . $age['peter'] . " years old.";
echo "<br>";
foreach($age as $x=>$x_value)
{
    echo "Key=" . $x . ", Value=" . $x_value;
    echo "<br>";
}
echo "<hr>";
echo $_SERVER['REMOTE_PORT'];
echo $_SERVER['SCRIPT_FILENAME'];
echo $_SERVER['SERVER_PORT'];
echo $_SERVER['REMOTE_ADDR'];
echo "<hr>";
//php 冒泡
$arr = array(5, 3, 6, 2, 8, 10);
for ($i = count($arr) - 1; $i >= 0; $i--) {
    for ($j = 0; $j < $i; $j++) {
        if ($arr[$j + 1] > $arr[$j]) {
            $aa = $arr[$j + 1];
            $arr[$j + 1] = $arr[$j];
            $arr[$j] = $aa;
        }
    }
}
print_r($arr);
var_dump($arr);
echo "<hr>";
echo "<hr>";
echo "<hr>";
echo "<hr>";
echo "<hr>";
echo "<hr>";
echo "<hr>";
echo "<hr>";
echo "<hr>";
