<?php
/**
 * @copyright Copyright PayFort 2012-2016 
 */
ob_clean();
if(!isset($_REQUEST['r'])) {
    echo 'Page Not Found!';
    exit;
}
require_once 'PayfortIntegration.php';

$objFort = new PayfortIntegration();

if( !session_id() )
    session_start();

$objFort ->amount = $_SESSION['Amount'];
$objFort ->customerEmail= $_SESSION['Email'];
$objFort ->customerName = $_SESSION['CustomerName'];
$objFort ->sandboxMode = $_SESSION['SandBox'] ;

$objFort ->merchantIdentifier =$_SESSION['merchantIdentifier'];
$objFort->accessCode =$_SESSION['accessCode'];
$objFort->SHARequestPhrase=$_SESSION['SHARequestPhrase'];
$objFort->SHAResponsePhrase=$_SESSION['SHAResponsePhrase'];
$objFort->itemName=$_SESSION['itemName'];
$objFort->currency=$_SESSION['currency'];
$objFort->language=$_SESSION['lang'];


if($_REQUEST['r'] == 'getPaymentPage') {
    //die($_REQUEST['paymentMethod']);
    $objFort->processRequest('installments_merchantpage');
}
elseif($_REQUEST['r'] == 'merchantPageReturn') {
    $objFort->processMerchantPageResponse();
}
elseif($_REQUEST['r'] == 'processResponse') {
    $objFort->processResponse();
}
else{
    echo 'Page Not Found!';
    exit;
}
?>

