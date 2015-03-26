<?php /* Smarty version 2.3.1, created on 2015-03-17 15:45:19
         compiled from default/views/month_print/outlook_ajax_template.html */ ?>
<?php $this->_load_plugins(array(
array('function', 'assign', 'default/views/month_print/outlook_ajax_template.html', 244, false),
array('modifier', 'date_format', 'default/views/month_print/outlook_ajax_template.html', 244, false),
array('modifier', 'string_format', 'default/views/month_print/outlook_ajax_template.html', 245, false),)); ?>








<?php $this->_config_load("default.conf", null, 'local'); ?>

<?php $this->_config_load("lang.$USER_LANG", null, 'local'); ?>



<html>
<head>
<style>
a {
 text-decoration:none;
}
td {
 font-family: Arial, Helvetica, sans-serif;
}
div.tiny { width:1px; height:1px; font-size:1px; }
#bigCalHeader {
    width: 100%;
    height: 20%;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 1em;
}
#bigCalText {
    float: left;
}
#provname {
    font-size: 2em;
}
#daterange {
    font-size: 1.8em;
    font-weight: bold;
}

#bigCal {
    width: 100%;
    height: 80%;
    overflow: hidden;
    background-color: lightblue;
    font-family: Arial, Helvetica, sans-serif;
}
#bigCal table {
    border-collapse: collapse;
    width: 100%;
    height: 100%;
}
#bigCal table th {
    height: 5%;
    text-align: center;
    width: 13%;
    font-size: 0.7em;
}
#bigCal table td {
    height: 15%;
    white-space: nowrap;
    overflow: hidden;
}
.pagebreak {
    page-break-after: always;    
}

/* these are for the small datepicker DIV */
#datePicker {
    float: right;
    padding: 5px;
    text-align: center;
    background-color: lightblue;
}
#datePicker td {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 0.7em;
}
#datePicker table {
    border-collapse: collapse;
}
#datePicker .tdDOW-small {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10px;
    vertical-align: top; 
    background-color: lightblue;
    text-align: center;
    border-bottom: 1px solid black;
    padding: 2px 3px 2px 3px;
}
#datePicker .tdWeekend-small {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10px;
    vertical-align: top;
    border: none;
    padding: 2px 3px 2px 3px;
    background-color: #dddddd;
    color: #999999;
}

#datePicker .tdOtherMonthDay-small {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10px;
    vertical-align: top;
    border: none;
    padding: 2px 3px 2px 3px;
    background-color: #ffffff;
    color: #999999;
}

#datePicker .tdMonthName-small {
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    font-style: normal 
}

#datePicker .tdMonthDay-small {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10px;
    vertical-align: top;
    border: none;
    padding: 2px 3px 2px 3px;
    background-color: #ffffff;
}
#datePicker .currentWeek {
    border-top: 1px solid blue;
    border-bottom: 1px solid blue;
    background-color: lightblue;
}
#datePicker .currentDate {
    border: 1px solid blue;
    background-color: blue;
    color: lightblue;
}

/* the DIV of times */
#times {
    border-right: 1px solid black;
}
#times table {
    border-collapse: collapse;
    width: 100%;
    margin: 0px;
    padding: 0px;
}
#times table td {
    border: 0px;
    border-top: 1px solid  black;
    margin: 0px;
    padding: 0px;
    font-size: 10pt;
}
.timeslot {
    height: <?php echo $timeslotHeightVal.$timeslotHeightUnit; ?>;
    margin: 0px; 
    padding: 0px;
}
.schedule {
    background-color: pink;
    vertical-align: top;
    padding: 0px;
    margin: 0px;
    border: 1px solid #999999;
}
/* types of events */
.event_in {
    background-color: white;
    width: 100%; 
}
.event_out {
    background-color: pink;
    width: 100%; 
}
.event_appointment {
    overflow: hidden;
    width: 100%;
    font-size: 0.8em;
    border-bottom: 1px solid lightgrey;
    height: 1.4em;
}
.event_noshow {
    overflow: hidden;
    width: 100%;
    font-size: 0.8em;
    border-bottom: 1px solid lightgrey;
}
.event_reserved {
    overflow: hidden;
    width: 100%;
    font-size: 0.8em;
    border-bottom: 1px solid lightgrey;
}
</style>

<script type="text/javascript" src="<?php  echo $GLOBALS['webroot']  ?>/library/js/jquery-1.2.2.min.js"></script>

</head>
<body>

<?php 

 // build a day-of-week (DOW) list so we may properly build the calendars later in this code
 $DOWlist = array();
 $tmpDOW = pnModGetVar(__POSTCALENDAR__, 'pcFirstDayOfWeek');
 // bound check and auto-correction
 if ($tmpDOW <0 || $tmpDOW >6) { 
    pnModSetVar(__POSTCALENDAR__, 'pcFirstDayOfWeek', '0');
    $tmpDOW = 0;
 }
 while (count($DOWlist) < 7) {
    array_push($DOWlist, $tmpDOW);
    $tmpDOW++;
    if ($tmpDOW > 6) $tmpDOW = 0;
 }

 // this is my proposed setting in the globals config file so we don't
 // need to mess with altering the pn database AND the config file
 //pnModSetVar(__POSTCALENDAR__, 'pcFirstDayOfWeek', $GLOBALS['schedule_dow_start']);

 $A_CATEGORY  =& $this->_tpl_vars['A_CATEGORY'];
 $A_EVENTS  =& $this->_tpl_vars['A_EVENTS'];
 $providers =& $this->_tpl_vars['providers'];
 $times     =& $this->_tpl_vars['times'];
 $interval  =  $this->_tpl_vars['interval'];
 $viewtype  =  $this->_tpl_vars['VIEW_TYPE'];
 $PREV_WEEK_URL = $this->_tpl_vars['PREV_WEEK_URL'];
 $NEXT_WEEK_URL = $this->_tpl_vars['NEXT_WEEK_URL'];
 $PREV_DAY_URL  = $this->_tpl_vars['PREV_DAY_URL'];
 $NEXT_DAY_URL  = $this->_tpl_vars['NEXT_DAY_URL'];

 $Date =  postcalendar_getDate();
 if (!isset($y)) $y = substr($Date, 0, 4);
 if (!isset($m)) $m = substr($Date, 4, 2);
 if (!isset($d)) $d = substr($Date, 6, 2);

 $provinfo = getProviderInfo();
 ?>

<?php $this->_plugins['function']['assign'][0](array('var' => "dayname",'value' => $this->_run_mod_handler('date_format', true, $this->_tpl_vars['DATE'], "%w")), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?>
<?php $this->_plugins['function']['assign'][0](array('var' => "day",'value' => $this->_run_mod_handler('string_format', true, $this->_run_mod_handler('date_format', true, $this->_tpl_vars['DATE'], "%d"), "%1d")), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?>
<?php $this->_plugins['function']['assign'][0](array('var' => "month",'value' => $this->_run_mod_handler('string_format', true, $this->_run_mod_handler('date_format', true, $this->_tpl_vars['DATE'], "%m"), "%1d")), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?>
<?php $this->_plugins['function']['assign'][0](array('var' => "year",'value' => $this->_run_mod_handler('string_format', true, $this->_run_mod_handler('date_format', true, $this->_tpl_vars['DATE'], "%Y"), "%4d")), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?>

<?php 

// start out without adding a pagebreak
$addPagebreak = false;

// This loops once for each provider to be displayed.
//
foreach ($providers as $provider) {
    // output a pagebreak, if needed
    if ($addPagebreak) { echo "<div class='pagebreak'></div>"; }
    $addPagebreak = true;

    echo "<div id='bigCalHeader'>";
    //echo "<img src='/images/cfa_logo_small.gif' style='position:relative; z-index:-100'/>";

    echo "<div id='bigCalText'>";
    // output the provider name
    echo "<span id='provname'>".$provider['fname'] . " " . $provider['lname']."</span>";
    echo "<br>";
    // output the date range
    $atmp = array_keys($A_EVENTS);
    echo "<span id='daterange'>";
    echo  xl(date('F', strtotime($Date))). " " . date('Y', strtotime($Date));
    echo "</span>";
    echo "</div>";

    // output a calendar for the subsequent month
    list($nyear, $nmonth, $nday) = explode(" ", date("Y m d", strtotime($Date)));
    $nmonth++;
    if ($nmonth > 12) { $nyear++; $nmonth=1; }
    echo "<div id='datePicker'>";
    PrintDatePicker(strtotime($nyear."-".$nmonth."-1"), $DOWlist, $this->_tpl_vars['A_SHORT_DAY_NAMES']);
    echo "</div>";
    
    // output a small calendar for the chosen month
    echo "<div id='datePicker'>";
    PrintDatePicker(strtotime($Date), $DOWlist, $this->_tpl_vars['A_SHORT_DAY_NAMES']);
    echo "</div>";

    echo "</div>"; // end the bigCalHeader
    
    echo "<div id='bigCal'>";
    
    $providerid = $provider['id'];

    echo "<table>\n";

    // output day of week headers
    echo " <tr>\n";
    $defaultDate = ""; // used when creating link for a 'new' event
    $in_cat_id = 0; // used when creating link for a 'new' event
    $dowCount = 0;
    foreach ($A_EVENTS as $date => $events) {
        if ($defaultDate == "") $defaultDate = date("Ymd", strtotime($date));
        echo "<th>";
        echo xl(date("l", strtotime($date)));
        echo "</th>";
        if ($dowCount++ == 6) { break; }
    }
    echo " </tr>\n";

    // For each day...
    // output a TD with an inner containing DIV positioned 'relative'
    foreach ($A_EVENTS as $date => $events) {
        $eventdate = substr($date, 0, 4) . substr($date, 5, 2) . substr($date, 8, 2);

        $gotoURL = pnModURL(__POSTCALENDAR__,'user','view',
                        array('tplview'=>$template_view,
                        'viewtype'=>'day',
                        'Date'=> date("Ymd", strtotime($date)),
                        'pc_username'=>$pc_username,
                        'pc_category'=>$category,
                        'pc_topic'=>$topic));

        if (date("w", strtotime($date)) == $DOWlist[0]) { echo "<tr>"; }
        echo "<td class='schedule'>";
        echo "<div style='position: relative; height: 100%; width: 100%;'>\n";
        echo "<div style='width:100%; font-size: 0.8em; text-align:right; background-color:lightgrey; padding:1px 2px 1px 2px;'>";
        echo date("d", strtotime($date))."</div>";

        if (count($events) == 0) { echo "&nbsp;"; }
        
        foreach ($events as $event) {
            // skip events for other providers
            // yeah, we've got that sort of overhead here... it ain't perfect
            if ($providerid != $event['aid']) { continue; }

            // Omit IN and OUT events to reduce clutter in this month view
            if (($event['catid'] == 2) || ($event['catid'] == 3)) { continue; }

            // specially handle all-day events
            if ($event['alldayevent'] == 1) {
                $tmpTime = $times[0];
                if (strlen($tmpTime['hour']) < 2) { $tmpTime['hour'] = "0".$tmpTime['hour']; }
                if (strlen($tmpTime['minute']) < 2) { $tmpTime['minute'] = "0".$tmpTime['minute']; }
                $event['startTime'] = $tmpTime['hour'].":".$tmpTime['minute'].":00";
                $event['duration'] = ($calEndMin - $calStartMin) * 60;  // measured in seconds
            }

            // figure the start time and minutes (from midnight)
            $starth = substr($event['startTime'], 0, 2);
            $startm = substr($event['startTime'], 3, 2);
            $eStartMin = $starth * 60 + $startm;
            $startDateTime = strtotime($date." ".$event['startTime']);

            // determine the class for the event DIV based on the event category
            $evtClass = "event_appointment";
            switch ($event['catid']) {
                case 1:  // NO-SHOW appt
                    $evtClass = "event_noshow";
                    break;
                case 2:  // IN office
                    $evtClass = "event_in";
                    break;
                case 3:  // OUT of office
                    $evtClass = "event_out";
                    break;
                case 4:  // VACATION
                case 8:  // LUNCH
                case 11: // RESERVED
                    $evtClass = "event_reserved";
                    break;
                default: // some appointment
                    $evtClass = "event_appointment";
                    break;
            }
            
            // now, output the event DIV


            $eventid = $event['eid'];
            $patientid = $event['pid'];
            $commapos = strpos($event['patient_name'], ",");
            $lname = substr($event['patient_name'], 0, $commapos);
	    $fname = substr($event['patient_name'], $commapos + 2);
            $patient_dob = $event['patient_dob'];
            $patient_age = $event['patient_age'];
            $catid = $event['catid'];
            $comment = addslashes($event['hometext']);
            $catname = $event['catname'];
            $title = "Age $patient_age ($patient_dob)";

            // format the time specially
            $displayTime = date("g", $startDateTime);
            if (date("i", $startDateTime) == "00") {
                $displayTime .= (date("a", $startDateTime));
            }
            else {
                $displayTime .= (date(":ia", $startDateTime));
            }

            $content = "";
            if ($comment && $GLOBALS['calendar_appt_style'] < 4) $title .= " " . $comment;

            if ($catid == 4 || $catid == 8 || $catid == 11) {
                if ($catid ==  4) $catname = xl("VACATION");
                else if ($catid ==  8) $catname = xl("LUNCH");
                else if ($catid == 11) $catname = xl("RESERVED");

                $content .= $displayTime." ";
                $content .= $catname;
                if ($comment) $content .= " - $comment";
            }
            else {
                // some sort of patient appointment

                $content .= $displayTime. " ";
                if ($catid == 1) $content .= "<strike>";
                $content .= htmlspecialchars($lname);
                if ($catid == 1) $content .= "</strike>";
            }

            echo "<div class='".$evtClass."' style='background-color:".$event['catcolor'].";'>";
            echo $content;
            echo "</div>\n";
        } // end EVENT loop

        echo "</div>";
        echo "</td>";
        if (date("w", strtotime($date)) == $DOWlist[6]) { echo "</tr>"; }
    } // end date

    echo "</table>\n";
    echo "</div>";
} // end provider

 // [-**-]
 // [-include file="$TPL_NAME/views/global/footer.html"-]
 // [-include file="$TPL_NAME/views/footer.html"-]

/* output a small calendar, based on the date-picker code from the normal calendar */
function PrintDatePicker($caldate, $DOWlist, $daynames) {

    $cMonth = date("m", $caldate);
    $cYear = date("Y", $caldate);
    $cDay = date("d", $caldate);

    echo '<table>';
    echo '<tr>';
    echo '<td colspan="7" class="tdMonthName-small">';
    echo date('F Y', $caldate);
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    foreach ($DOWlist as $dow) {
        echo "<td class='tdDOW-small'>".$daynames[$dow]."</td>";
    }
    echo '</tr>';
    
    // to make a complete week row we need to compute the real
    // start and end dates for the view
    list ($year, $month, $day) = explode(" ", date('Y m d', $caldate));
    $startdate = strtotime($year.$month."01");
    while (date('w', $startdate) != $DOWlist[0]) { $startdate -= 60*60*24; }

    $enddate = strtotime($year.$month.date("t", $month));
    while (date('w', $enddate) != $DOWlist[6]) { $enddate += 60*60*24; }

    $currdate = $startdate;
    while ($currdate <= $enddate) {
        if (date('w', $currdate) == $DOWlist[0]) {
            echo "<tr>";
        }

        // we skip outputting some days
        $skipit = false;

        // set the TD class
        $tdClass = "tdMonthDay-small";
        if (date('m', $currdate) != $month) {
            $tdClass = "tdOtherMonthDay-small";
            $skipit = true;
        }
        if ((date('w', $currdate) == 0) || (date('w', $currdate) == 6)) {
            $tdClass = "tdWeekend-small";
        }

        if (date('Ymd',$currdate) == $Date) {
            // $Date is defined near the top of this file
            // and is equal to whatever date the user has clicked
            $tdClass .= " currentDate";
        }

        // add a class so that jQuery can grab these days for the 'click' event
        $tdClass .= " tdDatePicker";

        // output the TD
        $td = "<td ";
        $td .= "class=\"".$tdClass."\" ";
        //$td .= "id=\"".date("Ymd", $currdate)."\" ";
        $td .= "id=\"".date("Ymd", $currdate)."\" ";
        $td .= "title=\"Go to week of ".date('M d, Y', $currdate)."\" ";
        $td .= "> ".date('d', $currdate)."</td>\n";
        if ($skipit == true) { echo "<td></td>"; }
        else { echo $td; }
   
        // end of week row
        if (date('w', $currdate) == $DOWlist[6]) echo "</tr>\n";

        // time correction = plus 1000 seconds, for some unknown reason
        $currdate += (60*60*24)+1000;
    }
    echo "</table>";
}
// end DatePicker, small calendar output

 ?>

</body>

<script language='JavaScript'>
$(document).ready(function(){
    window.print();
    window.close();
});
</script>


</html>