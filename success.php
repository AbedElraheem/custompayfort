<?php
$to = esc_attr( get_option('map_option_1'));;
$subject = 'Successful complete payment';
$headers = array('Content-Type: text/html; charset=UTF-8');


$Body='
    <html>
        <head>
            <style>table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            
            table td, table th {
                border: 1px solid #ddd;
                padding: 8px;
            }
            
            table tr:nth-child(even){background-color: #f2f2f2;}
            
            table tr:hover {background-color: #ddd;}
            
            table th {
                padding-top: 12px;
                padding-bottom: 12px;
                text-align: left;
                background-color: #4CAF50;
                color: white;
            }</style>
        </head>
    </html>
    <body>

    Hello,<br />
    A Successful complete payment done on najahi website with below details. 
    <br />
    <table>
        <tr>
            <th>
                Parameter Name
            </th>
            <th>
                Parameter Value
            </th>
        </tr>
';  
    
       foreach($_REQUEST as $k => $v) {
        $Body.="<tr>";
        $Body.="<td>$k</td><td>$v</td>";
        $Body.= "</tr>";
       } 
    
       $Body.='</table></body></html>';







$R =  wp_mail( $to, $subject, $Body, $headers );

writeSuccessPayLog($_REQUEST);


   
?>


<section class="nav">
        <ul>
            <li class="lead" > Your Information</li>
            <li class="lead" > Pay</li>
            <li class="active lead" > Done</li>
        </ul>
    </section>
    <section class="confirmation">
        <label class="" for="" >Success</label>
        <small>Thank You For Your Payment</small>
    </section>

    <section class="order-confirmation">
        <label for="" class="lead">Payment ID : <?php echo $_REQUEST['fort_id']?></label>
    </section>

    <div class="h-seperator"></div>
    <!--
    <section class="details">
        <h3>Response Details</h3>
        <br/>
        <table>
            <tr>
                <th>
                    Parameter Name
                </th>
                <th>
                    Parameter Value
                </th>
            </tr>
        <?php
           foreach($_REQUEST as $k => $v) {
               echo "<tr>";
               echo "<td>$k</td><td>$v</td>";
               echo "</tr>";
           } 
        ?>
        </table>
    </section>
    -->

