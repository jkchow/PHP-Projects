<?

require("../global.php");


ob_start();

echo "REQUEST:\n";
print_r($_REQUEST);

echo "GET:\n";
print_r($_GET);

echo "POST:\n";
print_r($_POST);

$_res =  ob_get_contents();
echo "\n";
ob_end_clean();



LogFile::write($_res);

echo "1";


?>