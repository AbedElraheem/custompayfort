<?php
if(isset($_GET['download']) and $_GET['download'] == '1'){
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=SuccessPayments.csv');

// create a file pointer connected to the output stream
    echo file_get_contents(dirname(__FILE__) . '/SuccessPayments.csv');
    exit();
}
if(isset($_GET['download']) and $_GET['download'] == '2'){
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=ErrorPayments.csv');

// create a file pointer connected to the output stream
    echo file_get_contents(dirname(__FILE__) . '/ErrorPayments.csv');
    exit();
}

/*
Plugin Name: Payfort Plugin
Plugin URI: php-jo.com
Description: Add custom payfort for najah.
Author: AbedElraheem
Version:  0.0.1
Author URI: php-jo.com
*/




include_once 'style.php';

add_action('admin_menu', function() {
    add_options_page( 'Payfort plugin settings', 'payfort plugin', 'manage_options', 'payfort-plugin', 'payfort_plugin_page' );
});
 
 
add_action( 'admin_init', function() {
    register_setting( 'payfort-plugin-settings', 'map_option_1' );
    register_setting( 'payfort-plugin-settings', 'map_option_2' );
    register_setting( 'payfort-plugin-settings', 'map_option_3' );
    register_setting( 'payfort-plugin-settings', 'map_option_4' );
    register_setting( 'payfort-plugin-settings', 'map_option_5' );
    register_setting( 'payfort-plugin-settings', 'map_option_6' );
    register_setting( 'payfort-plugin-settings', 'map_option_7' );
    register_setting( 'payfort-plugin-settings', 'map_option_8' );
    register_setting( 'payfort-plugin-settings', 'map_option_9' );
    

   
});
 
 function writeSuccessPayLog($R){
    $messages = implode(';',$R);
    $file = __DIR__.'/SuccessPayments.csv';
    
    
    file_put_contents($file, $messages.PHP_EOL , FILE_APPEND | LOCK_EX);
   
 }
function payfort_plugin_page() {
    


  ?>
    <div class="wrap">
      <form action="options.php" method="post">
 
        <?php
          settings_fields( 'payfort-plugin-settings' );
          do_settings_sections( 'payfort-plugin-settings' );
        ?>
        <table>
             
            <tr>
                <th>Send Email To</th>
                <td><input type="text" placeholder="Email" name="map_option_1" value="<?php echo esc_attr( get_option('map_option_1') ); ?>" size="50" /></td>
            </tr>
          
 
            <tr>
                <th>SandBox</th>
                <td>
                    <label>
                        <input type="radio" name="map_option_2" value="No" <?php echo esc_attr( get_option('map_option_2') ) == 'No' ? 'checked="checked"' : ''; ?> /> No <br/>
                    </label>
                    <label>
                        <input type="radio" name="map_option_2" value="Yes" <?php echo esc_attr( get_option('map_option_2') ) == 'Yes' ? 'checked="checked"' : ''; ?> /> Yes
                    </label>
                </td>
            </tr>
 
            <tr>
                <th>merchantIdentifier</th>
                <td><input type="text" placeholder="Merchant Identifier" name="map_option_3" value="<?php echo esc_attr( get_option('map_option_3') ); ?>" size="50" /></td>
            </tr>
            <tr>
                <th>Access Code</th>
                <td><input type="text" placeholder="Access Code" name="map_option_4" value="<?php echo esc_attr( get_option('map_option_4') ); ?>" size="50" /></td>
            </tr>
            <tr>
                <th>SHA Request Phrase</th>
                <td><input type="text" placeholder="SHA Request Phrase" name="map_option_5" value="<?php echo esc_attr( get_option('map_option_5') ); ?>" size="50" /></td>
            </tr>
            <tr>
                <th>SHA Response Phrase</th>
                <td><input type="text" placeholder="SHA Response Phrase" name="map_option_6" value="<?php echo esc_attr( get_option('map_option_6') ); ?>" size="50" /></td>
            </tr>
         
            <tr>
                <th>Item Name</th>
                <td><input type="text" placeholder="Item Name" name="map_option_7" value="<?php echo esc_attr( get_option('map_option_7') ); ?>" size="50" /></td>
            </tr>
            <tr>
                <th>Currency</th>
                <td><input type="text" placeholder="Currency" name="map_option_8" value="<?php echo esc_attr( get_option('map_option_8') ); ?>" size="3" /></td>
            </tr> 
            <tr>
                <th>Language</th>
                <td><input type="text" placeholder="Language" name="map_option_9" value="<?php echo esc_attr( get_option('map_option_9') ); ?>" size="2" /></td>
            </tr>


            <tr>
                <td><?php submit_button(); ?></td>
            </tr>
 
        </table>
 
      </form>


        <div>
            
            <div><h1>Success Payments</h1></div>
            <table id="table">
                <tr>
                    <?php 
                    $f = fopen(dirname(__FILE__) . '/SuccessPayments.csv', 'r');
                    $line = fgets($f);
                    fclose($f);
                    
                    $Data = explode(';' , $line);
                    foreach($Data as $k=>$val){
                        echo '<th>' . $val .  '</th>';
                    }
                    ?>

                </tr>
            <?php 
                $handle = fopen(dirname(__FILE__) . "/SuccessPayments.csv", "r");
                if ($handle) {
                    $c=0;
                    while (($line = fgets($handle)) !== false) {
                        $c++;
                        if($c == 1)continue;
                        $Data = explode(';' , $line);
                        echo '<tr>';
                        foreach($Data as $k=>$val){
                            echo '<td>' . $val .  '</td>';
                        }
                        echo '</tr>';
                    }

                    fclose($handle);
                } else {
                    // error opening the file.
                } 

                ?>
            </table>
            <br />
            <a href="?download=1">
                 <input type="button" class="button button-primary" value="Dawnload">
            </a>
        </div>







    </div>
  <?php
}

function callback_for_setting_up_scripts() {
 

    wp_register_style( 'custom-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
    // or
    // Register the script like this for a theme:
        wp_register_style( 'custom-style', get_template_directory_uri() . 'assets/css/style.css' );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_style( 'custom-style' );

    wp_register_style( 'custom-style2', plugins_url( 'assets/css/normalize.css', __FILE__ ) );
    // or
    // Register the script like this for a theme:
        wp_register_style( 'custom-style2', get_template_directory_uri() . 'assets/css/normalize.css' );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_style( 'custom-style2' );
    
}

add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');



if(isset($_REQUEST['pl']) and $_REQUEST['pl'] == 'payment'){
    if(empty($_POST)){
        header('Location: /userpay');
        exit();
    }
    if(empty($_POST['amount'])){
        header('Location: /userpay?error');
        exit();
    }
    if(empty($_POST['fname'])){
        header('Location: /userpay?error');
        exit();
    }
    if(empty($_POST['lname'])){
        header('Location: /userpay?error');
        exit();
    }
    if(empty($_POST['email'])){
        header('Location: /userpay?error');
        exit();
    }
}

if(isset($_REQUEST['pl']) and $_REQUEST['pl'] == 'r'){
    require_once 'route.php';
    exit();
}

if(!isset($_REQUEST['pl'])){
    return;
}else{
    //var_dump($_REQUEST);
}



require_once 'PayfortIntegration.php';

if( !session_id() ){
        session_start();
}
 
$Amount = isset($_REQUEST['amount'])?$_REQUEST['amount']:'';
$Email  = isset($_REQUEST['email'])?$_REQUEST['email']:'';
$CustomerName = isset($_REQUEST['fname'])?$_REQUEST['lname']:'';
$SandBox      = (esc_attr( get_option('map_option_2')) == 'Yes')?true:false;





$_SESSION['Amount'] = $Amount;
$_SESSION['Email'] = $Email;
$_SESSION['CustomerName'] = $CustomerName;
$_SESSION['SandBox'] = $SandBox;

$_SESSION['merchantIdentifier'] = esc_attr( get_option('map_option_3'));
$_SESSION['accessCode'] =esc_attr( get_option('map_option_4'));
$_SESSION['SHARequestPhrase'] = esc_attr( get_option('map_option_5'));
$_SESSION['SHAResponsePhrase'] = esc_attr( get_option('map_option_6'));
$_SESSION['itemName'] =esc_attr( get_option('map_option_7'));
$_SESSION['currency']     = esc_attr( get_option('map_option_8'));
$_SESSION['lang']     = esc_attr( get_option('map_option_9'));




$objFort = new PayfortIntegration();

$objFort ->amount= $_SESSION['Amount'];
$objFort ->customerEmail  = $_SESSION['Email'];
$objFort ->customerName = $_SESSION['CustomerName'] ;
$objFort ->sandboxMode = $_SESSION['SandBox'];


$objFort ->merchantIdentifier =$_SESSION['merchantIdentifier'];
$objFort->accessCode =$_SESSION['accessCode'];
$objFort->SHARequestPhrase=$_SESSION['SHARequestPhrase'];
$objFort->SHAResponsePhrase=$_SESSION['SHAResponsePhrase'];
$objFort->itemName=$_SESSION['itemName'];
$objFort->currency=$_SESSION['currency'];
$objFort->language=$_SESSION['lang'];




$amount =  $objFort->amount;
$currency = $objFort->currency;

$totalAmount = $amount;
$paymentMethod = 'installments_merchantpage';
function html_form_code(){
    global $objFort,$totalAmount,$paymentMethod,$currency,$Amount,$Email,$CustomerName;
?>

<?php
if(isset($_REQUEST['pl']) and $_REQUEST['pl'] == 'error'){
    require_once 'error.php';
}elseif(isset($_REQUEST['pl']) and $_REQUEST['pl'] == 'success'){
    require_once 'success.php';
}else{?>

<section class="confirmation">
        <label>Complete Your Payment</label>
       
    
  
    <?php if($paymentMethod == 'cc_merchantpage' || $paymentMethod == 'installments_merchantpage') ://merchant page iframe method ?>
        
      
            <?php
                $merchantPageData = $objFort->getMerchantPageData($paymentMethod);
                
                $postData = $merchantPageData['params'];
              

                $gatewayUrl = $merchantPageData['url'];
              
               
            ?>
            <div class="cc-iframe-display">
                <div id="div-pf-iframe" style="display:none">
                    <div class="pf-iframe-container">
                        <div class="pf-iframe" id="pf_iframe_content">
                        </div>
                    </div>
                </div>
            </div>
     <script type="text/javascript">
        jQuery(document).ready(function () {
           
            var paymentMethod = '<?php echo $paymentMethod?>';
            

            //load merchant page iframe
            if(paymentMethod == 'cc_merchantpage' || paymentMethod == 'installments_merchantpage') {
                var $URL = '/wp-content/plugins/custompayfort/payment/?pl=r&r=getPaymentPage';
                getPaymentPage(paymentMethod,$URL);
            }
        });
    </script>

    <?php endif; ?>
     
   
    </section>
  <?php }?>
    
   
    <?php } ?>
<?php




function wptuts_scripts_with_jquery()
{
    // Register the script like this for a plugin:
    wp_register_script( 'custom-script', plugins_url( 'assets/js/checkout.js', __FILE__ ), array( 'jquery' ) );
    // or
    // Register the script like this for a theme:
    wp_register_script( 'custom-script', get_template_directory_uri() . 'assets/js/checkout.js', array( 'jquery' ) );
 
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'custom-script' );
}

function cf_shortcode() {
	ob_start();
	wptuts_scripts_with_jquery();
	html_form_code();

	return ob_get_clean();
}
add_action( 'wp_enqueue_scripts', 'wptuts_scripts_with_jquery' );


add_shortcode( 'Payfort', 'cf_shortcode' );



?>
  