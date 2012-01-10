<?php
session_start();
require_once 'inc/settings.inc.php';
require_once 'inc/functions.inc.php';
require_once 'inc/login.inc.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo __('timetracking') ?></title>
    <link type="text/css" href="css/style.css" rel="stylesheet"/>
    <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="js/datepickers.js"></script>
</head>
<body>
<div id="container">
<?php
    $startdate = isset($_POST['startdate']) ? $_POST['startdate'] : firstOfMonth();
    $enddate = isset($_POST['enddate']) ? $_POST['enddate'] : lastOfMonth();
    ?>
<?php include 'inc/menu.inc.php';?>
<a href="http://www.kenters.com" id="logo"><img src="http://www.kenters.com/images/logo.png" alt="Jeroen Kenters Web Development" width="147" height="50" /></a>

<h1><?php echo __('timetracking'); ?></h1>
<form method="post" action="">
    <input type="hidden" id="startfield" name="startdate" value="<?php echo htmlentities($startdate); ?>">
    <input type="hidden" id="endfield" name="enddate" value="<?php echo htmlentities($enddate); ?>">

    <div class="datepicker">
        <strong><?php echo __('timetracking.startdate'); ?>:</strong>
        <div id="startdate">&nbsp;</div>
    </div>
    <div class="datepicker">
        <strong><?php echo __('timetracking.enddate'); ?>:</strong>
        <div id="enddate">&nbsp;</div>
    </div>
    <div class="datepicker">
        <strong><?php echo __('timetracking.showproject'); ?>:</strong><br />
        <select name="project">
            <option value=""><?php echo __('timetracking.showproject.all'); ?></option>
            <?php
            $projects = getData($domain.'projects?client='.$clients[$user]['client']);
            $projects = simplexml_load_string($projects);
            $myProjects = array();
            foreach ($projects as $project) {
                $myProjects[(int)$project->{'id'}] = (string)$project->{'name'};
            }
            unset($projects, $project);

            foreach($myProjects as $projectId => $projectName)
            {
                echo '<option value="'.$projectId.'"'.(isset($_POST['project']) && $_POST['project'] == $projectId ? ' selected="selected"' : '').'>'.htmlentities($projectName).'</option>';
            }

            ?>
        </select><br />
        <input type="submit" value="<?php echo __('submit'); ?>">
        
        <p><strong><?php echo __('timetracking.mydetails'); ?>:</strong></p>
        <p>
        <?php
        $clientData = getData($domain.'clients/'.$clients[$user]['client']);
        $clientData = simplexml_load_string($clientData);
        echo $clientData->name . '<br />' .nl2br($clientData->details);
        ?>
        </p>

    </div>
    <br class="clear"/>
</form>

<hr />

<h1><?php echo __('timetracking.billable'); ?></h1>
<table>
    <tr>
        <th><?php echo __('timetracking.date'); ?></th>
        <th><?php echo __('timetracking.project'); ?></th>
        <th><?php echo __('timetracking.hours'); ?></th>
        <th><?php echo __('timetracking.billed'); ?></th>
        <th><?php echo __('timetracking.notes'); ?></th>
    </tr>
    <?php
    $hoursRounded = 0;

    $data = getData($domain.'people/292217/entries?from=' . $startdate . '&to=' . $enddate . '&billable=yes');
    $data = simplexml_load_string($data);
    foreach ($data as $entry)
    {
        if (array_key_exists((int)$entry->{'project-id'}, $myProjects)) {

            if(isset($_POST['project']) && !empty($_POST['project']) && $_POST['project'] != (int)$entry->{'project-id'})
            {
                continue;
            }
            $hoursRounded += ceil((float)$entry->{'hours'} * 60 / 15) * 0.25;

            echo '<tr>
                    <td>' . $entry->{'spent-at'} . '</td>
                    <td>' . $myProjects[(int)$entry->{'project-id'}] . '</td>
                    <td class="hours">' . number_format(round((float)$entry->{'hours'} * 60 / 15) * 0.25, 2) . '</td>
                    <td>' . ($entry->{'is-billed'} == 'true' ? __('yes') : __('no')) . '</td>
                    <td>' . $entry->{'notes'} . '</td>
                </tr>';
        }
    }
    echo '<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="hours">' . number_format($hoursRounded,2) . '</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>';
    ?>
</table>

<h1><?php echo __('timetracking.unbillable'); ?></h1>
<table>
    <tr>
        <th><?php echo __('timetracking.date'); ?></th>
        <th><?php echo __('timetracking.project'); ?></th>
        <th><?php echo __('timetracking.hours'); ?></th>
        <th><?php echo __('timetracking.notes'); ?></th>
    </tr>
    <?php
    $hoursRounded = 0;

    $data = getData($domain.'people/292217/entries?from=' . $startdate . '&to=' . $enddate . '&billable=no');
    $data = simplexml_load_string($data);
    foreach ($data as $entry)
    {
        if (array_key_exists((int)$entry->{'project-id'}, $myProjects)) {

            if(isset($_POST['project']) && !empty($_POST['project']) && $_POST['project'] != (int)$entry->{'project-id'})
            {
                continue;
            }
            $hoursRounded += ceil((float)$entry->{'hours'} * 60 / 15) * 0.25;

            echo '<tr>
                    <td>' . $entry->{'spent-at'} . '</td>
                    <td>' . $myProjects[(int)$entry->{'project-id'}] . '</td>
                    <td class="hours">' . number_format(ceil( (float)$entry->{'hours'} * 60 / 15) * 0.25, 2) . '</td>
                    <td>' . $entry->{'notes'} . '</td>
                </tr>';
        }
    }
    echo '<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="hours">' . number_format($hoursRounded, 2) . '</td>
            <td>&nbsp;</td>
          </tr>';
    ?>
</table>
</div>
</body>
</html>