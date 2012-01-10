<?php
session_start();
require_once 'inc/settings.inc.php';
require_once 'inc/functions.inc.php';
require_once 'inc/login.inc.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title><?php echo __('invoices'); ?></title>
    <link type="text/css" href="css/style.css" rel="stylesheet"/>
    <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="js/datepickers.js"></script>
</head>
<body>
<div id="container">
    <?php
    $user = $_SESSION['user'];

    include 'inc/menu.inc.php';
    ?>
    <a href="http://www.kenters.com" id="logo"><img src="http://www.kenters.com/images/logo.png"
                                                        alt="Jeroen Kenters Web Development" width="147"
                                                        height="50"/></a>

    <h1><?php echo __('invoices.last50'); ?></h1>
    <table>
        <tr>
            <th><?php echo __('invoices.number'); ?></th>
            <th><?php echo __('invoices.date'); ?></th>
            <th><?php echo __('invoices.amount'); ?></th>
            <th><?php echo __('invoices.duedate'); ?></th>
            <th><?php echo __('invoices.due'); ?></th>
        </tr>
        <?php
        $due = 0;

        $data = getData($domain.'invoices?client='.$clients[$user]['client']);
        $data = simplexml_load_string($data);

        foreach ($data as $invoice)
        {
            $due += (float)$invoice->{'due-amount'};
            echo '<tr>
                <td><a href="'.$domain.'/client/invoices/'.$invoice->{'client-key'}.'" target="_blank">' . $invoice->{'number'} . '</a></td>
                <td>' . $invoice->{'issued-at'} . '</td>
                <td class="hours">' . number_format((float)$invoice->amount, 2) . '</td>
                <td>' . $invoice->{'due-at'} . '</td>
                <td class="hours">' . number_format((float)$invoice->{'due-amount'}, 2) . '</td>
            </tr>';
        }
        echo '<tr>
            <td colspan="4">&nbsp;</td>
            <td class="hours"><strong>' . number_format($due, 2  ) . '</strong></td>
        </tr>';
        ?>
    </table>
</div>
</body>
</html>