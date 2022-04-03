<?php


function fd($dep) {
    return implode(',', array_keys(array_flip(explode(', ', $dep))));
}

function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}


function CheckCookieLogin()
{

    global $user;

    $uname = $_COOKIE['username'];
    if (!empty($uname)) {
        $cok = explode("_", $uname);

        if ($cok[1] == "admin") {

            $result = mysqli_query($mycon,"select users.*  from users as users 
			where 
			users.cookies = " . $this->db->qstr($uname) . " and
			users.account_id = '0'
			") or die (mysqli_error($mycon));
            $num = mysqli_num_rows($result);

            $login_attribute = mysqli_fetch_array($result);


            if ($num == 1) {
                $login_attribute['login'] = true;
            } else {
                $login_attribute['login'] = false;
            }

        } elseif ($cok[1] == "client") {


            $result = mysqli_query($mycon,"select users.* , account.* from users as users 
inner join account as account 
on (users.account_id = account.account_id) 
where 
users.cookies = " . $this->db->qstr($uname) . " and
(users.status ='1' || users.status ='2' ) and
(account.status = '1' || account.status = '6' )  ") or die (mysqli_error($mycon));
            $num = mysqli_num_rows($result);

            $login_attribute = mysqli_fetch_array($result);


            if ($num == 1) {
                $login_attribute['login'] = true;
            } else {
                $login_attribute['login'] = false;
            }


        }


        $login = array_keys($Login_attribute);
        //print_r($Login_attribute);

        foreach ($Login_attribute as $key => $var) {
            if (!is_numeric($key)) $_SESSION[$key] = $var;
        }
        $_SESSION['logged_in'] = true;

        $_SESSION['user_is_loggedin'] = 1;
        $_SESSION['cookie'] = $uname;
        // reset expiry date
        //	setcookie("username",$uname,time()+3600*24*365,'/',SITEURL);
    }
}


//Start koko
function get_account_name($account_id)
{

    $query = mysqli_query($mycon,"select * from account where account_id = " . $account_id . "") or die(mysqli_error($mycon));
    if (mysqli_num_rows($query) == 1) {
        $row = mysqli_fetch_array($query);
        return $row['account_name'];
    } else {
        return false;
    }
}

function get_user_name($value)
{
    if (is_numeric($value)) {
        $query = mysqli_query($mycon,"select name from users where user_id = '" . $value . "'") or die (mysqli_error($mycon));
        if (mysqli_num_rows($query) == 1) {
            $row = mysqli_fetch_assoc($query);
            return $row['name'];
        }
    } else {
        return $value;
    }
}

function curPageURL($siteurl)
{


    $pageURL = 'https';

// echo "-".$_SERVER["HTTPS"];

    //if ( strpos($siteurl,"https") === 0 ) {$pageURL .= "s";}
    $pageURL .= "://";
    $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

//  if ($_SERVER["SERVER_PORT"] != "80") {
//   $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
//  } else {
//  }
    return $pageURL;
}

//End koko
function clean_String($string)
{
    $string = preg_replace('/\s+/', ' ', trim($string));

    return $string;
}

function get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function timezoneList()
{
    $timezoneIdentifiers = DateTimeZone::listIdentifiers();
    $utcTime = new DateTime('now', new DateTimeZone('UTC'));

    $tempTimezones = array();
    foreach ($timezoneIdentifiers as $timezoneIdentifier) {
        $currentTimezone = new DateTimeZone($timezoneIdentifier);

        $tempTimezones[] = array(
            'offset' => (int)$currentTimezone->getOffset($utcTime),
            'identifier' => $timezoneIdentifier
        );
    }

// 	// Sort the array by offset,identifier ascending
// 	usort($tempTimezones, function($a, $b) {

// 		return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
// 	});

    $timezoneList = array();
    foreach ($tempTimezones as $tz) {
        $sign = ($tz['offset'] > 0) ? '+' : '-';
        $offset = gmdate('H:i', abs($tz['offset']));
        $timezoneList[$tz['identifier']] = $tz['identifier'] . '  (UTC ' . $sign . $offset . ') ';
    }

    return $timezoneList;
}

//*Typical use:   Large Print - White on Black
function printrow_console_header_dark($row, $cw, $sz, $attr = array())
{
    echo "<tr>";
    for ($n = 0; $n < count($row); $n++) {
        echo "<td valign=bottom align=center width=" . $cw[$n] . " " . $attr[$n] . "><font color=white size=" . $sz[$n] . " face=tahoma><b>" . $row[$n] . "</b></font></td>";
    }
    echo "</tr>\r\n";
}

//*Typical use:
function showrow_line($row, $cw, $sz, $attr = array())
{
    echo "<tr>";
    for ($n = 0; $n < count($row); $n++) {
        echo "<td width=" . $cw[$n] . " " . $attr[$n] . "><font color=black size=" . $sz[$n] . " face=verdana>  " . $row[$n] . "  </font></td>";
    }
    echo "</tr>\r\n";
}


//*Typical use: same as standard showrow, but bolded
function showrowbold($row, $attr = array())
{
    echo "<tr>";
    for ($n = 0; $n < count($row); $n++) {
        echo "<td " . $attr[$n] . "><font face=verdana size=\"2\"><b>" . $row[$n] . "</b></font></td>";
    }
    echo "</tr>\r\n";
}

//*Typical use: Chart printing - Header
function printrow_console_header($row, $cw, $sz, $attr = array())
{
    echo "<tr>";
    for ($n = 0; $n < count($row); $n++) {
        echo "<td valign=bottom align=center width=" . $cw[$n] . " " . $attr[$n] . "><font color=black size=" . $sz[$n] . " face=tahoma><b>" . $row[$n] . "</b></font></td>";
    }
    echo "</tr>\r\n";
}

//*Filter quotes that will screw up a MySql Update stmt, from Input data.
// Also, remove any HTML, JavsScript or SQL Injection attempts.
//***No need to differentiate string/numeric.... Numerics are sanitized when sprintf-formatted.
function filterin($str, $cleanit = null)
{
    global $filtererr;
    //*****  The Method:
    //1. No backslashes. (dont use stripslashes - it only removes one - intented only to reverse addslashes)
    //2. No preceding or trailing spaces or whitespace.
    //3. NO HTML/JS coding.  (replace with their entities)
    //   addslashes will thwart SQL injection by escaping any quotes - single or double.
    //4. Kill JS scripts
    //5. First, remove any htmlentities, before converting to htmlentities or we would get ie: &AMP; -> &AMP;AMP;
    //6. One exception: allow <b> & </b>.
    //*****  The Parms:  "C":Clean it for DB update.   "D":clean it for Display.
    //1.
    $xstr = str_replace("\\", "", $str, $ct);
    if ($ct > 0) $count = $ct;
    //2.
    $xstr = preg_replace('/\s\s+/', ' ', $xstr); //squish out whitespace blocks to single spaces
    $xstr = trim($xstr);
    //3.
    $xstr = html_entity_decode($xstr);
    //4.
    $xstr = str_ireplace("<script>", "", $xstr, $ct);
    if ($ct > 0) $count = $ct;
    $xstr = str_ireplace("</script>", "", $xstr, $ct);
    if ($ct > 0) $count = $ct;
    //5.
    if ($cleanit == "D")                                         //Clean it for HTML Display and inclusion in arrays... (NOT for use outside of HTML -> use filterout for that)
        $cleanstr = htmlentities($xstr, ENT_QUOTES);                 //change all specialchars to htmlentities, for Display *Including* both types of Quotes.
    else                                                         //Clean it for DB Update...
        $cleanstr = addslashes(htmlentities($xstr, ENT_NOQUOTES));   //leave the Quotes ' " alone addslashes will neuter them.
    //6.
    $cleanstr = str_ireplace("&lt;b&gt;", "<b>", $cleanstr);
    $cleanstr = str_ireplace("&lt;/b&gt;", "</b>", $cleanstr);
    //Error message if we found bad stuff.
    if ($count > 0) $filtererr = "Invalid digits, please use simple letters and numbers.";
    if ($cleanit == "C" or $cleanit == "D")
        return ($cleanstr);
    else
        return ($str);
}

//*get the current Date-Time and adjust for Local Timezone.
function adjusteddatetime()
{
    global $timezone_adj;                                     //set in dbconnect.php
    if ($timezone_adj == "") $timezone_adj = "+0 hours";

    $adjdate = date("Y-m-d-H-i");
    return $adjdate;
}

//*get the current Date and adjust for Local Timezone.
function adjusteddate()
{
    global $timezone_adj;                                     //set in dbconnect.php
    if ($timezone_adj == "") $timezone_adj = "+0 hours";

    $adjdate = date("Y-m-d");
    return $adjdate;

}

//* TEXTBOX
function mktb($name, $val, $rows = 0, $cols = 0)
{
    $r = "<textarea name=$name";
    if ($rows) $r .= " rows=$rows";
    if ($cols) $r .= " cols=$cols";
    $r .= ">$val</textarea>";
    return $r;
}

function dateformats($d)
{
    //* first, determine the format
    $d = str_replace(" ", "-", $d);
    if (strlen($d) == 10) $fmt = 1;
    if (strlen($d) == 8) {
        $pos = strpos($d, "-");
        if ($pos === false) $fmt = 2; else  $fmt = 3;
    }
    if (strlen($d) == 6) $fmt = 4;
    if (strlen($d) == 5) $fmt = 5;
    if (strlen($d) == 4) $fmt = 6;
    if (strlen($d) == 2) $fmt = 7;

    $today = adjusteddate();
    $yyyy = substr($today, 0, 4);
    $mm = substr($today, 5, 2);
    $dd = substr($today, 8, 2);
    switch ($fmt) {
        case 1:
            $fdate = $d;
            break;
        case 2:
            $fdate = substr($d, 0, 4) . "-" . substr($d, 4, 2) . "-" . substr($d, 6, 2);
            break;
        case 3:
            $fdate = "20" . $d;
            break;
        case 4:
            $fdate = "20" . substr($d, 0, 2) . "-" . substr($d, 2, 2) . "-" . substr($d, 4, 2);
            break;
        case 5:
            $fdate = $yyyy . "-" . substr($d, 0, 5);
            break;
        case 6:
            $fdate = $yyyy . "-" . substr($d, 0, 2) . "-" . substr($d, 2, 2);
            break;
        case 7:
            if ($d > $dd) $mm--;
            if ($mm < 1) {
                $mm = 1;
                $yyyy--;
            }
            $mm = sprintf("%02.0f", $mm);
            $fdate = $yyyy . "-" . $mm . "-" . $d;
            break;
    }
    return $fdate;
}


//*********************************************
//  Accept various time formats               *
// 1.hh:mm (hh mm) (h:mm) (h mm) 24hr fmt     *
// 2.hhmm  (hmm)                 24hr fmt     *
// 3.hh:mmA(h:mmA) (or AM/PM) (am/pm)         *
// 4.hhmmA (hmmA) (or AM/PM) (a/p)            *
//*********************************************
function timeformats($t)
{
    //* first, determine the format
    $t = strtoupper($t);
    $t = str_replace(" ", ":", $t);
    $t = str_replace("AM", "A", $t);
    $t = str_replace("PM", "P", $t);
    $posa = strpos($t, "A");
    $posp = strpos($t, "P");
    //add a zero in front ?
    for ($i = 0; $i < strlen($t) + 1; $i++) {
        if (is_numeric(substr($t, $i, 1))) $x .= substr($t, $i, 1);
    }
    if (strlen($x) == 3) $t = "0" . $t;
    if ($posa === false and $posp === false)  //24hr fmt
    {
        if (strlen($t) == 5) $fmt = 1; else  $fmt = 2;
    } else                                        //12hr fmt
    {
        if (strlen($t) == 6) $fmt = 3; else  $fmt = 4;
        $x = substr($t, 0, 2);
        if ($posp > 0 and $x < 12) $x = $x + 12;
        if ($posa > 0 and $x == 12) $x = 0;
        //if ($x < 10)  $x .= "0";
    }

    switch ($fmt) {
        case 1:
            $ftime = substr($t, 0, 2) . ":" . substr($t, 3, 2);
            break;
        case 2:
            $ftime = substr($t, 0, 2) . ":" . substr($t, 2, 2);
            break;
        case 3:
            $ftime = $x . ":" . substr($t, 3, 2);
            break;
        case 4:
            $ftime = $x . ":" . substr($t, 2, 2);
            break;
    }
    return $ftime;
}


function validate_order()
{

    global $client, $vec_details;
    $error_msg = "";


    $w = trim($_POST['weight_s']);
    if ($w == "") $w = 0;
    $p = trim($_POST['pieces_s']);
    if ($p == "") $p = 0;
    $v = trim($_POST['volume_s']);
    if ($v == "") $v = 0;
    //if ($quotes_control < 2)  $errormsg = "";  //If it's OFF - drop any error msgs so far
    //*Any errormsg so far is only warnings.... These next are Stoppers !
    if (!is_numeric($w) or !is_numeric($p) or !is_numeric($v)) {
        $error_msg = "Weight/pieces/volume<br>must be numeric";
        $br = "<br>";
    }
    if ($client['ref_mandatory'] == "Y" and trim($_POST['refrence']) == "") {
        $error_msg .= "$br A reference code is Required";
        $br = "<br>";
    }
    if ($client['pieces_mandatory'] == "Y" and trim($_POST['pieces_s']) == "") {
        $error_msg .= "$br Number of pieces is Required";
        $br = "<br>";
    }
    if ($client['weight_mandatory'] == "Y" and trim($_POST['weight_s']) == "") {
        $error_msg .= "$br Weight is Required";
        $br = "<br>";
    }

    if ($_POST['service_id'] < 1) {
        $error_msg .= "$br Please select a Service";
        $br = "<br>";
    }


    /////vechile validation

    if ($w > $vec_details->max_weight) {
        $tracer .= "D ";
        if ($error_msg != "") $error_msg .= "<br>";
        $error_msg .= "Weight exceeds capacity for this vehicle";
    }
    //}
    //check volume
    //if ($volume != "")  {
    if ($v > $vec_details->max_volume) {
        $tracer .= "E ";
        if ($error_msg != "") $error_msg .= "<br>";
        $error_msg .= "Volume exceeds capacity for this vehicle";
    }


    return $error_msg;
}


function get_user($id, $value = "")
{
    $q = mysqli_query($mycon,"select * from users where user_id = '$id'") or die(mysqli_error($mycon));
    $row = mysqli_fetch_array($q);
//echo $row[$value];
    if ($value == "") return $row;
    else return $row[$value];
}

function time_req($id)
{

    $t[1] = "before";
    $t[2] = "after";
    $t[3] = "at";

    return $t[$id];
}

//* Prepare a field returned from a form checkbox, to be saved as Y/N in the DB.
function yesno($val)
{
    if (isset($val))
        $v = "Y";
    else
        $v = "N";
    // if passed back hidden in a form (not edited) then it will be Y/N *not* unset
    if ($val == "N") $v = "N";
    return $v;
}

function convert_time_utc($date)
{
    $given = new DateTime($date);
    $given->setTimezone(new DateTimeZone("UTC"));

    return (($given->getTimestamp()) * 1000);
}

function makedatetime($datetime)
{

    $mysql_datetime = date('Y-m-d H:i:s', $datetime);
    echo $mysql_datetime;

    return $mysql_datetime;
}

function convert_utc_time($date)
{

    //$given = new DateTime();
// 	$given->setTimezone(new DateTimeZone("UTC"));
    //$given->setTimestamp($data);
// 	$given->setTimezone(new DateTimeZone(date_default_timezone_get()));

    return date("Y-m-d h:i:s", substr($date, 0, strlen($date) - 3));

}

function check_duplication($table, $coloum, $value, $status)
{
    $query = mysqli_query($mycon,"select count(*) as num from $table where $coloum = '$value'  and status = '" . $status . "' ") or die (mysqli_error($mycon));
    $row = mysqli_fetch_assoc($query);

    if ($query) return $row['num'];
    else return false;

}

function remove_elm($arr, $key, $val, $within = FALSE)
{
    foreach ($arr as $i => $array)
        if ($within && stripos($array[$key], $val) !== FALSE && (gettype($val) === gettype($array[$key])))
            unset($arr[$i]);
        elseif ($array[$key] === $val)
            unset($arr[$i]);

    return array_values($arr);
}

function check_duplication_users($table, $coloum, $value, $account_id)
{
    $query = mysqli_query($mycon,"select count(*) as num from $table where $coloum = '$value' and account_id='$account_id'") or die (mysqli_error($mycon));
    $row = mysqli_fetch_array($query);

    if ($query) return $row['num'];
    else return false;

}

function valid_email($str)
{
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

function get_opp_color($color)
{

    $org = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');

    $ops = array('F', 'E', 'D', 'C', 'B', 'A', '9', '8', '7', '6', '5', '4', '3', '2', '1', '0');

    $opp_color = str_replace($org, $ops, $color);

    return $opp_color;

}

function oppColour($c, $inverse = false)
{
    if (strlen($c) == 3) { // short-hand
        $c = $c{0} . $c{0} . $c{1} . $c{1} . $c{2} . $c{2};
    }
    if ($inverse) { // => Inverse Colour
        $r = (strlen($r = dechex(255 - hexdec($c{0} . $c{1}))) < 2) ? '0' . $r : $r;
        $g = (strlen($g = dechex(255 - hexdec($c{2} . $c{3}))) < 2) ? '0' . $g : $g;
        $b = (strlen($b = dechex(255 - hexdec($c{4} . $c{5}))) < 2) ? '0' . $b : $b;
        return $r . $g . $b;
    } else { // => Monotone based on darkness of original
        return array_sum(array_map('hexdec', str_split($c, 2))) > 255 * 1.5 ? '000000' : 'FFFFFF';
    }
}

function get_rate($dt)
{

    $dt = date("H:i", strtotime($dt));
    $t = str_replace(":", ".", $dt);


    if ($t < 1) $dtodkey = "rate00";

    if ($t >= 1 and $t < 2) $dtodkey = "rate01";

    if ($t >= 2 and $t < 3) $dtodkey = "rate02";

    if ($t >= 3 and $t < 4) $dtodkey = "rate03";

    if ($t >= 4 and $t < 5) $dtodkey = "rate04";

    if ($t >= 5 and $t < 6) $dtodkey = "rate05";

    if ($t >= 6 and $t < 7) $dtodkey = "rate06";

    if ($t >= 7 and $t < 8) $dtodkey = "rate07";

    if ($t >= 8 and $t < 9) $dtodkey = "rate08";

    if ($t >= 9 and $t < 10) $dtodkey = "rate09";

    if ($t >= 10 and $t < 11) $dtodkey = "rate10";

    if ($t >= 11 and $t < 12) $dtodkey = "rate11";

    if ($t >= 12 and $t < 13) $dtodkey = "rate12";

    if ($t >= 13 and $t < 14) $dtodkey = "rate13";

    if ($t >= 14 and $t < 15) $dtodkey = "rate14";

    if ($t >= 15 and $t < 16) $dtodkey = "rate15";

    if ($t >= 16 and $t < 17) $dtodkey = "rate16";

    if ($t >= 17 and $t < 18) $dtodkey = "rate17";

    if ($t >= 18 and $t < 19) $dtodkey = "rate18";

    if ($t >= 19 and $t < 20) $dtodkey = "rate19";

    if ($t >= 20 and $t < 21) $dtodkey = "rate20";

    if ($t >= 21 and $t < 22) $dtodkey = "rate21";

    if ($t >= 22 and $t < 23) $dtodkey = "rate22";

    if ($t >= 23 and $t < 24) $dtodkey = "rate23";

    return $dtodkey;
}
 

function setup_serviceprices($ord, $add_ser, $row_now,$pack_type,$Pack_options)   
{   
    global $row, $orders, $price_detail, $c_setting, $componentprices, $order, $piecestype;
    $x= ' '.$row_now['length'].' ,  '.$row_now['width'].' ,  '.$pack_type[$row_now['package_type']].' '.$row_now['glasscolour'].' ,'.$row_now['glassPrint'].', '.$row_now['glassType'].' , '.$row_now['glassPointing'];

    //* first deal with individual component overrides
    //* distinguish between zero calc/quote & zero Override.
    //* because we want to show zeros if overridden.
// print_r($ord);
// print_r($pack_type);
// print_r($Pack_options);
// print_r($row_now);  
// echo $x;
$pack_options_val=explode(',', $row_now['pack_options']);
// print_r($pack_options_val);

////removed for new design 

// if(count($pack_options_val) > 0 ){
// $pack_options_string=' , الخدمة : [';

// foreach($pack_options_val as $val){
//     $pack_options_string=$pack_options_string.' '.$Pack_options[$val].' , ';
// }
// $pack_options_string=$pack_options_string.' ]';
// }

$x= $x.$pack_options_string;
// echo $x;
    $componentprices = 0;
    $extrasprices = 0;
    $s = array();
    $sc = 0;
    $pkp = 0;
    $del = 0;
    $w = 0;

    for ($i = 0; $i < count($ord); $i++) {

        // $s[$sc]["des"]='الطول :'.$row['length'].' , العرض : '.$row['width'].' , السمك : '.$pack_type[$row['package_type']].' , الخدمة : '.$pack_type[$row['pack_options']];
        // echo $s[$sc]["des"];
        if (isset($ord[$i]["1"])) {
            $f="";
            if ($ord[$i]["1"]["override"] > 0) $f = $ord[$i]["1"]["override"];
            else $f = $ord[$i]["1"]["price"];
            $componentprices += $f;

            $s[$sc]["typ"] = "S";
            $s[$sc]["svc"] =  $ord[$i]["1"]['name'];
            $s[$sc]["des"] = " تشغيل ".$ord[$i]["1"]['name']." ".$x;
            $s[$sc]["chg"] = sprintf("%01.2f", round($f, 2));
            $sc++;
            
        }

        if (isset($ord[$i]["2"])) {
            $f="";
            if ($ord[$i]["2"]["override"] > 0) $f = $ord[$i]["2"]["override"];
            else $f = $ord[$i]["2"]["price"];
            $componentprices += $f;

            $s[$sc]["typ"] = "S";
            $s[$sc]["svc"] =  $ord[$i]["2"]['name'];
            $s[$sc]["des"] = "تشغيل ".$ord[$i]["2"]['name']." ".$x;
            $s[$sc]["chg"] = sprintf("%01.2f", round($f, 2));
            $sc++;
            
        }

        if (isset($ord[$i]["3"])) {
            $f="";
            if ($ord[$i]["3"]["override"] > 0) $f = $ord[$i]["3"]["override"];
            else $f = $ord[$i]["3"]["price"];
            $componentprices += $f;

            $s[$sc]["typ"] = "S";
            $s[$sc]["svc"] =  $ord[$i]["3"]['name'];
            $s[$sc]["des"] = "تشغيل ".$ord[$i]["3"]['name']." ".$x;
            $s[$sc]["chg"] = sprintf("%01.2f", round($f, 2));
            $sc++;
            
        }

        if (isset($ord[$i]["4"])) {
            $f="";
            if ($ord[$i]["4"]["override"] > 0) $f = $ord[$i]["4"]["override"];
            else $f = $ord[$i]["4"]["price"];
            $componentprices += $f;

            $s[$sc]["typ"] = "S";
            $s[$sc]["svc"] =  $ord[$i]["4"]['name'];
            $s[$sc]["des"] = "تشغيل ".$ord[$i]["4"]['name']." ".$x;
            $s[$sc]["chg"] = sprintf("%01.2f", round($f, 2));
            $sc++;
            
        }

        if (isset($ord[$i]["9"])) {

            $f="";
            if ($ord[$i]["9"]["override"] > 0) $f = $ord[$i]["9"]["override"];
            else $f = $ord[$i]["9"]["price"];
            $componentprices += $f;

            $s[$sc]["typ"] = "S";
            $s[$sc]["svc"] =  $ord[$i]["9"]['name'];
            $s[$sc]["des"] = "تشغيل ".$ord[$i]["9"]['name']." ".$x;
            $s[$sc]["chg"] = sprintf("%01.2f", round($f, 2));
            $sc++;
            
        }

        for($j=1;$j<10;$j++){

        
        if (isset($ord[$i]["add_".$j])) {
            $f="";
            if ($ord[$i]["add_".$j]["override"] > 0) $f = $ord[$i]["add_".$j]["override"];
            else $f = $ord[$i]["add_".$j]["price"];
            $componentprices += $f;

            $s[$sc]["typ"] = "C";
            $s[$sc]["svc"] =  $ord[$i]["add_".$j]['name'];
            $s[$sc]["des"] = "خدمة  :  ".$ord[$i]["add_".$j]['name'];
            $s[$sc]["chg"] = sprintf("%01.2f", round($f, 2));
            $sc++;    
        }

    }
        


    }

   

    //* With one Caveat.....                                                       *
    //* IF.. the "price"(entire waybill-override) is less than the sum of the      *
    //* components, we will NOT show any components & just show the one price.     *



    


    return $s;
}

function get_tax($tax_id)
{
    $q = mysqli_query($mycon,"select * from tax where tax_id = '$tax_id'") or die (mysqli_error($mycon));
    $z = mysqli_fetch_object($q);

    return $z->tax_rate;

}

function tax_fs_calc($taxg_id, $fsovrd, $lineamount, $chargetype)
{

    global $taxrate, $grptax1;
//echo $taxg_id."<br>";

    $q = mysqli_query($mycon,"select * from tax_group where taxgroup_id = '$taxg_id'") or die (mysqli_error($mycon));
    $taxgroup_details = mysqli_fetch_object($q);

    $fsrate = "";

    if ($fsovrd != "") $fsrate = $fsovrd / 100;
    else $fsrate = $taxgroup_details->taxgroup_fs_rate / 100;

//echo $fsrate."<br>";


    $tax_on = explode(',', $taxgroup_details->taxgroup_on);

    if ($tax_on[0] == 0 && ($chargetype == "S" || $chargetype == "Distance" || $chargetype == "v" || $chargetype == "w" || $chargetype == "p")) $fsrate = 0;

    if ($tax_on[1] == 0 && $chargetype == "W") $fsrate = 0;

    if ($tax_on[2] == 0 && ($chargetype == "a" || $chargetype == "vs")) $fsrate = 0;

    $linefsamount = $lineamount * ($fsrate);

    /*echo $fsrate."<br>";
    echo $lineamount."<br>";
    echo $linefsamount."<br>";*/


    if ($taxgroup_details->taxgroup_tax1_on_fs == "1") $fstax1able = $linefsamount; else $fstax1able = 0;
    if ($taxgroup_details->taxgroup_tax2_on_fs == "1") $fstax2able = $linefsamount; else $fstax2able = 0;


//*taxtype 1 ie.1=GST, as 1st tax.
    if ($taxgroup_details->taxgroup_tax1 == 1) {

        $linetax1 = ($lineamount + $fstax1able) * (get_tax("1") / 100);
        //echo "ahmed".$linetax1;
        $firsttax = $linetax1;
    }
//*taxtype 2 ie.1=PST, as 1st tax.
    if ($taxgroup_details->taxgroup_tax1 == 2) {
        $linetax2 = ($lineamount + $fstax1able) * (get_tax("2") / 100);
        $firsttax = $linetax2;
    }
//*taxtype 3 ie.3=TVQ, as 1st tax.
    if ($taxgroup_details->taxgroup_tax1 == 3) {
        $linetax3 = ($lineamount + $fstax1able) * (get_tax("3") / 100);
        $firsttax = $linetax3;
    }
//*taxtype 4 ie.4=HST, as 1st tax.
    if ($taxgroup_details->taxgroup_tax1 == 4) {
        $linetax4 = ($lineamount + $fstax1able) * (get_tax("4") / 100);
        $firsttax = $linetax4;
    }
//*taxtype 5 ie.5=etc, as 1st tax.
    if ($taxgroup_details->taxgroup_tax1 == 5) {
        $linetax5 = ($lineamount + $fstax1able) * (get_tax("5") / 100);
        $firsttax = $linetax5;
    }

//*taxtype 1 ie.1=GST, as 2nd tax.
    if ($taxgroup_details->taxgroup_tax2 == 1) {
        if ($taxgroup_details->taxgroup_tax2_on_tax1 == "1") $ft = $firsttax; else $ft = 0;
        $linetax1 = ($lineamount + $ft + $fstax2able) * (get_tax("1") / 100);
    }
//*taxtype 2 ie.1=PST, as 2nd tax.
    if ($taxgroup_details->taxgroup_tax2 == 2) {
        if ($taxgroup_details->taxgroup_tax2_on_tax1 == "1") $ft = $firsttax; else $ft = 0;
        $linetax2 = ($lineamount + $ft + $fstax2able) * (get_tax("2") / 100);
    }
//*taxtype 3 ie.3=TVQ, as 2nd tax.
    if ($taxgroup_details->taxgroup_tax2 == 3) {
        if ($taxgroup_details->taxgroup_tax2_on_tax1 == "1") $ft = $firsttax; else $ft = 0;
        $linetax3 = ($lineamount + $ft + $fstax2able) * (get_tax("3") / 100);
    }
//*taxtype 4 ie.4=HST, as 2nd tax.
    if ($taxgroup_details->taxgroup_tax2 == 4) {
        if ($taxgroup_details->taxgroup_tax2_on_tax1 == "1") $ft = $firsttax; else $ft = 0;
        $linetax4 = ($lineamount + $ft + $fstax2able) * (get_tax("4") / 100);
    }
//*taxtype 5 ie.5=etc, as 2nd tax.
    if ($taxgroup_details->taxgroup_tax2 == 5) {
        if ($taxgroup_details->taxgroup_tax2_on_tax1 == "1") $ft = $firsttax; else $ft = 0;
        $linetax5 = ($lineamount + $ft + $fstax2able) * (get_tax("5") / 100);
    }


    if ($taxgroup_details->taxgroup_tax1 != 0) {

        if ($taxgroup_details->taxgroup_tax1_on_fs == 1) {
            $tax1 = ($lineamount + $linefsamount) * (get_tax($taxgroup_details->taxgroup_tax1) / 100);
        } else {
            $tax1 = $lineamount * (get_tax($taxgroup_details->taxgroup_tax1) / 100);
        }


    }


    $calcs = array();
    $calcs[0] = $linefsamount;
    $calcs[1] = $linetax1;
    $calcs[2] = $linetax2;
    $calcs[3] = $linetax3;
    $calcs[4] = $linetax4;
    $calcs[5] = $linetax5;
    $calcs[6] = $fsrate * 100;
    return $calcs;


}


function change_index_to_key($array)
{
    $key_array = array();

    for ($i = 0; $i < count($array); $i++) {
        foreach ($array[$i] as $key => $value) {
            $key_array[$key] = $value;
        }
    }
    return $key_array;
}


//* Validate date format
function is_date($date)
{
    if ($date == "0000-00-00") return true;  // empty date IS Valid.
    $dp = explode("-", $date);
    if (count($dp) != 3) return false;
    if ($dp[0] < 2000) return false;
    if ($dp[0] > 2099) return false;
    if ($dp[1] > 12) return false;
    if ($dp[1] < 1) return false;
    if ($dp[2] > 31) return false;
    if ($dp[2] < 1) return false;
    for ($n = 0; $n < 3; $n++)
        if (!is_numeric($dp[$n])) return false;
    return true;
}

//* Validate time format
function is_time($t)
{
//* expect time formatted string -> "00:00"  ** actually any krap as a separator
    $hh = substr($t, 0, 2);
    $mm = substr($t, 3, 2);
    if (strlen($t) != 5) return false;
    substr_replace($t, ":", 2);
    if ($t == "00:00") return true;
    if (!is_numeric($hh . $mm)) return false;
    if ($hh < 0) return false;
    if ($hh > 23) return false;
    if ($hh == "  ") return false;
    if ($mm < 0) return false;
    if ($mm > 59) return false;
    if ($mm == "  ") return false;
    return true;
}

//* Validate date-time format
function is_datetime($d)
{
//* expect datetime formatted string -> "0000-00-00 00:00:00"
//* can't use explode b/c of inconsistent separators.
    $yyyy = substr($d, 0, 4);
    $mo = substr($d, 5, 2);
    $dd = substr($d, 8, 2);
    $hh = substr($d, 11, 2);
    $mm = substr($d, 14, 2);
    $ss = substr($d, 17, 2);
    if ($d == "0000-00-00 00:00:00") return true;  // empty date-time IS Valid.
    if (!is_numeric($yyyy . $mo . $dd . $hh . $mm . $ss)) return false;
    if ($yyyy < 2000) return false;
    if ($yyyy > 2099) return false;
    if ($mo < 1) return false;
    if ($mo > 12) return false;
    if ($dd < 1) return false;
    if ($dd > 31) return false;
    if ($hh < 0) return false;
    if ($hh > 23) return false;
    if (strlen($hh) != 2 or $hh == "  ") return false;
    if ($mm < 0) return false;
    if ($mm > 59) return false;
    if (strlen($mm) != 2 or $mm == "  ") return false;
    if ($ss < 0) return false;
    if ($ss > 59) return false;
    if (strlen($ss) != 2 or $ss == "  ") return false;
    return true;
}

function add_days($date, $days)
{
    $date = strtotime("+" . $days . " days", strtotime($date));
    return date("Y-m-d", $date);
}

function make_input_name($default_name)
{
    $default_name = str_replace(" ", "_1_", $default_name);
    return $default_name;
}

function get_driving_information($start, $finish, $fcode, $tocode, $raw = false)
{
    if (strcmp($start, $finish) == 0) {
        $time = 0;
        if ($raw) {
            $time .= ' seconds';
        }

        return array('distance' => 0, 'time' => $time);
    }

    $start = urlencode($start);
    $finish = urlencode($finish);

    $distance = 'unknown';
    $time = 'unknown';

    $url = 'http://maps.googleapis.com/maps/api/directions/xml?origin=' . urlencode($start . ',' . $fcode) . '&destination=' . urlencode($finish . ',' . $tocode) . '&sensor=false';
    if ($data = file_get_contents($url)) {
        $xml = new SimpleXMLElement($data);


        if (isset($xml->route->leg->duration->value) AND (int)$xml->route->leg->duration->value > 0) {
            if ($raw) {
                $distance = (string)$xml->route->leg->distance->text;
                $time = (string)$xml->route->leg->duration->text;
            } else {
                $distance = (int)$xml->route->leg->distance->value;// / 1000;// / 1.609344;
                $time = (int)$xml->route->leg->duration->value;
            }
        } else {
            throw new Exception('Could not find that route');
        }

        return array('distance' => $distance, 'time' => $time);
    } else {
        // throw new Exception('Could not resolve URL');
    }
}


function convert_distance($distance, $type)
{

    if ($type == "Km") {
        $distance = $distance / 1000;
    }
    if ($type == "Miles") {
        $distance = $distance / 1000 / 1.609344;
    }

    return round($distance);
}

function convert_big_distance($distance, $type)
{
    if ($type == "Km") {
        $distance = $distance * 1000;
    }
    if ($type == "Miles") {
        $distance = $distance * 1000 * 1.609344;
    }

    return ceil($distance);
}

function cal_distance($var, $arr, $lastvalue)
{

    $price = 0;
    $distance = $var;
//echo $distance.'-a-';

    $price = $arr[0]['price'];
    $distance = $distance - $arr[0]['distance'];

    if ($distance > 0) {


        for ($i = 1; $i < count($arr); $i++) {
//start for loop
//echo $arr[$i]['rate'];
            if ($arr[0]['rate'] == "1") {
                ///cal distacnce with rates


                if ($distance >= $arr[$i]['distance']) {


                    $price += ($arr[$i]['price'] * $arr[$i]['distance']);

                    $distance = $distance - $arr[$i]['distance'];

                } else {

                    //	$kprice = $arr[$i]['distance']/$arr[$i]['price'];


                    $price += ($arr[$i]['price'] * $distance);

                    $distance = 0;
                    break;

                }


                // if($distance > 0 )
// {
//   $price +=( ($distance)*$lastvalue);
// }

            } else {

                ///cal distance wwithout rate as bulk value for distace
                if ($distance >= $arr[$i]['distance']) {

                    $price += $arr[$i]['price'];
                    $distance = $distance - $arr[$i]['distance'];

                } else {

                    $price += $arr[$i]['price'];
                    break;
                }

            }
//end for loop
        }

    }
//echo "afetr:".$distance."last value".$lastvalue;


    return $price;

}

function showrow($row, $attr = array())
{
    echo "<tr>";
    for ($n = 0; $n < count($row); $n++) {
        echo "<td " . $attr[$n] . "><font face=verdana size=\"2\">" . $row[$n] . "</font></td>";
    }
    echo "</tr>\r\n";
}

function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {


        if (isset($array[$key]) && $array[$key] == $value)
            $results[] = $array;

        foreach ($array as $subarray)
            $results = array_merge($results, search($subarray, $key, $value));

    }

    return $results;
}

function time_elapsed_string($datetime, $full = false)
{

    $time_ago = strtotime($datetime);
    $cur_time = time();
    $time_elapsed = $cur_time - $time_ago;
    $seconds = $time_elapsed;
    $minutes = round($time_elapsed / 60);
    $hours = round($time_elapsed / 3600);
    $days = round($time_elapsed / 86400);
    $weeks = round($time_elapsed / 604800);
    $months = round($time_elapsed / 2600640);
    $years = round($time_elapsed / 31207680);
    // Seconds
    if ($seconds <= 60) {
        return "just now";
    } //Minutes
    else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "one minute ago";
        } else {
            return "$minutes minutes ago";
        }
    } //Hours
    else if ($hours <= 24) {
        if ($hours == 1) {
            return "an hour ago";
        } else {
            return "$hours hrs ago";
        }
    } //Days
    else if ($days <= 7) {
        if ($days == 1) {
            return "yesterday";
        } else {
            return "$days days ago";
        }
    } //Weeks
    else if ($weeks <= 4.3) {
        if ($weeks == 1) {
            return "a week ago";
        } else {
            return "$weeks weeks ago";
        }
    } //Months
    else if ($months <= 12) {
        if ($months == 1) {
            return "a month ago";
        } else {
            return "$months months ago";
        }
    } //Years
    else {
        if ($years == 1) {
            return "one year ago";
        } else {
            return "$years years ago";
        }
    }
}


//************************************************************************************
// this function serves 2 purposes:                                                  *
// (i)  break up $pcodes, attach prefix & assemble an array of elements in the zone. *
// (ii) check for FORMAT errors in $pcodes.                                          *
//      Error checking consists of:                                                  *
//      - incomplete from-thru range  ie: A1B-  or   -A1B                            *
//      - more than one hyphen                                                       *
//      - from higher than thru                                                      *
// ****** special characters 0-9 & A-Z ONLY  ******* NOT DONE YET *****************  *
//        duplicates...                                                              *
//        overlapping ranges...                                                      *
//     ...since this function only handles one row at a time, the error checks for,  *
//         duplicates & overlaps must be done in the main program.                   *
//************************************************************************************
function break_pc_into_list($p, $c)
{
    unset($err);
    $t = array();
    $c = str_replace(" ", "", $c);      //squish out all spaces
    if ($c == "") $err = "is blank";
    $c .= ",";                         //get the last one
    do {
        $c = str_replace(",,", ",", $c); //replace any double commas with singles
    } while (strpos($c, ",,"));
    do {
        $c = str_replace("--", "-", $c); //replace any double hyphens with singles
    } while (strpos($c, "--"));
    do {
        $pos = strpos($c, ",");         //dissect it into an array
        if ($pos > 0) {
            $t[] = substr($c, 0, $pos);            //$x= substr($c,0,$pos); echo "<br> >$c< &nbsp;&nbsp;&nbsp;&nbsp;*$pos* &nbsp;&nbsp; *$x*<br>";
            $c = trim(substr($c, $pos + 1));
        }
    } while ($pos > 0);
    foreach ($t as $pc) {
        //range:look for hyphen
        $dash = strpos($pc, "-");
        if ($dash === false) {
            //single postalcode
            $ret[] = $p . $pc;
            //echo ">$pc< *$dash* false<br><br>";
        } else {
            //postalcode range
            //echo ">$pc< *$dash* true<br><br>";
            if ($dash == 0) $err = "invalid range  " . $pc;
            if ($dash == strlen($pc) - 1) $err = "invalid range  " . $pc;
            if (!isset($err)) {
                $pos = strpos($pc, "-");
                $l = substr($pc, 0, $pos);
                $r = substr($pc, $pos + 1);
                if ($r <= $l) $err = "range from is equal or higher than thru";
            }
            if (!isset($err))
                $ret[] = $p . $l . "-" . $p . $r;
        }
        if (strpos($r, "-")) $err = "invalid range, more than one hyphen";
    }

    if (isset($err)) {
        $ret = array();
        $ret[] = "error";
        $ret[] = $err;
    }

    return $ret;
}


//************************************************************************
//Locate the postalcode in the lists (singles or ranges).                *
//                                                                       *
//we now have 2 array pairs,                                             *
//(each row is an individual range or single code with associated Zone)  *
// (i)Singles - Zone & postalcode.                                       *
//(ii)Ranges  - Zone & range.                                            *
//************************************************************************
function get_zone_from_postalcode($p, $ranges, $ranges_zone, $singles, $singles_zone)
{
    //global $ranges, $ranges_zone, $singles, $singles_zone;
    // now that we are using this in status_quick-function, globalizing variables in a function that
    // calls another function is problematic beyon it's value.  -  Just pass them in the call. !
    $p = strtoupper($p);              //uppercase it
    $p = str_replace(" ", "", $p);      //squish out all spaces
    $rangecnt = count($ranges);
    if ($rangecnt > 0) {
        for ($i = 0; $i < $rangecnt; $i++) {
            $pos = strpos($ranges[$i], "-");
            $l = substr($ranges[$i], 0, $pos);
            $l_len = strlen($l);
            $r = substr($ranges[$i], $pos + 1);
            $r_len = strlen($r);
            $p_len = strlen($p);
            $longest = max($l_len, $r_len, $p_len);
            $l = $l . "00000000";
            $l = substr($l, 0, $longest);
            $r = $r . "}}}}}}}}";
            $r = substr($r, 0, $longest);

            if ($p >= $l and $p <= $r) $ret = $ranges_zone[$i];
            //$xx = "$i * $l * $r * $pos *<br>";    //++++++++++++++++++++++++++++++++++++++
        }
    }
    $singlecnt = count($singles);
    if ($singlecnt > 0) {
        for ($i = 0; $i < $singlecnt; $i++) {
            $len = strlen($singles[$i]);
            $px = substr($p, 0, $len);
            if ($singles[$i] == $px) $ret = $singles_zone[$i];
        }
    }           //$ret = "999* $ranges[0] * $ranges[1] * $rangecnt * $longest * 999 *".$xx; //+++++++++++++++++++++++++++++++++++++++++++++++++++
    return $ret;
}


//******************************************          No more need to do this....
//  Validate Zone entered.                 *       ...they now come from the listbox.
//******************************************       **EXCEPT** from XPEntry.
function zonevalidate($zone)
{
    $zone = strtoupper($zone);
    $rz = mysqli_query($mycon,"select id from pricezones where zone='$zone'");
    $zonecount = mysqli_num_rows($rz);
    if ($zonecount == 0) return "";
    else                  return $zone;
}


function img_resize($saveToDir, $imagePath, $imageName, $max_x, $max_y)
{
    preg_match("'^(.*)\.(gif|jpe?g|png)$'i", $imageName, $ext);

    //echo $ext[2];

    switch (strtolower($ext[2])) {
        case 'jpg' :
        case 'jpeg':
            $im = imagecreatefromjpeg($imagePath);
            break;
        case 'gif' :
            $im = imagecreatefromgif($imagePath);
            break;
        case 'png' :
            $im = imagecreatefrompng($imagePath);

            break;
        default    :
            $stop = true;
            break;
    }

    //imagejpeg($im, 'image.jpg', 70);

    if (!isset($stop)) {
        $x = imagesx($im);
        $y = imagesy($im);

        if (($max_x / $max_y) < ($x / $y)) {
            $save = imagecreatetruecolor($max_x, $max_y);
        } else {
            $save = imagecreatetruecolor($max_x, $max_y);
        }
        imagecopyresized($save, $im, 0, 0, 0, 0, $max_x, $max_y, $x, $y);

        imagejpeg($save, "{$saveToDir}{$ext[1]}.jpg", 100);
        imagedestroy($im);
        imagedestroy($save);
    }
}


function sendIphoneCloudMessage($data, $pusk_key, $app_id)
{
    // Put your device token here (without spaces):
    $deviceToken = $pusk_key;
    // Put your private key's passphrase here:
    $passphrase = '';
    // Put your alert message here:
    $message = $data['alert'];

    ////////////////////////////////////////////////////////////////////////////////

    $ctx = stream_context_create();
    stream_context_set_option($ctx, 'ssl', 'local_cert', '/var/www/vhosts/courier-connex.com/freetrial/pushcert.pem');
    // stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
    stream_context_set_option($ctx, 'ssl', 'cafile', 'entrust_root_certification_authority.pem');

    // Open a connection to the APNS server
    $fp = stream_socket_client(
        'ssl://gateway.push.apple.com:2195', $err,
        $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

    if (!$fp)
        exit("Failed to connect: $err $errstr" . PHP_EOL);

//	echo 'Connected to APNS' . PHP_EOL;

    if (isset($data['silent']) && $data['silent'] == "1") {

        // Create the payload body
        //	$body['aps'] = array('message'=> $data['message']);
        $body['aps'] = array(
            'alert' => $message,
            'sound' => 'push2-mp3.mp3',
            'message' => $data['message'],
            'Content-available' => '1'

        );

    } else {
        // Create the payload body
        $body['aps'] = array(
            'alert' => $message,
            'sound' => 'push2-mp3.mp3',
            'message' => $data['message'],
            'Content-available' => '1'

        );
    }


    // Encode the payload as JSON
    $payload = json_encode($body);

    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));

    if (!$result)
        $m = 'Message not delivered' . PHP_EOL;
    else
        $m = 'Message successfully delivered' . PHP_EOL;

    //echo $m;
    // Close the connection to the server
    fclose($fp);
    return $m;

}

function sendGoogleCloudMessage($data, $ids, $apiKey)
{
    //------------------------------
    // Replace with real GCM API
    // key from Google APIs Console
    //
    // https://code.google.com/apis/console/
    //------------------------------

    $apiKey = $apiKey;

    //------------------------------
    // Define URL to GCM endpoint
    //------------------------------

    $url = 'https://android.googleapis.com/gcm/send';

    //------------------------------
    // Set GCM post variables
    // (Device IDs and push payload)
    //------------------------------

    $post = array(
        'registration_ids' => $ids,
        'data' => $data,
    );

    //------------------------------
    // Set CURL request headers
    // (Authentication and type)
    //------------------------------

    $headers = array(
        'Authorization: key=' . $apiKey,
        'Content-Type: application/json'
    );

    //------------------------------
    // Initialize curl handle
    //------------------------------

    $ch = curl_init();

    //------------------------------
    // Set URL to GCM endpoint
    //------------------------------

    curl_setopt($ch, CURLOPT_URL, $url);

    //------------------------------
    // Set request method to POST
    //------------------------------

    curl_setopt($ch, CURLOPT_POST, true);

    //------------------------------
    // Set our custom headers
    //------------------------------

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    //------------------------------
    // Get the response back as
    // string instead of printing it
    //------------------------------

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //------------------------------
    // Set post data as JSON
    //------------------------------

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

    //------------------------------
    // Actually send the push!
    //------------------------------

    $result = curl_exec($ch);

    //------------------------------
    // Error? Display it!
    //------------------------------

    if (curl_errno($ch)) {
        echo 'GCM error: ' . curl_error($ch);
    }

    //------------------------------
    // Close curl handle
    //------------------------------

    curl_close($ch);

    //------------------------------
    // Debug GCM response
    //------------------------------

    return $result;
}


function getDistance($addressFrom, $addressTo, $unit, $avoidtolls, $avoidhightways)
{
    //Change address format
    $formattedAddrFrom = str_replace(' ', '+', $addressFrom);
    $formattedAddrTo = str_replace(' ', '+', $addressTo);

    //Send request and receive json data
    $geocodeFrom = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $formattedAddrFrom . '&sensor=false');
    $outputFrom = json_decode($geocodeFrom);
    $geocodeTo = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $formattedAddrTo . '&sensor=false');
    $outputTo = json_decode($geocodeTo);

    //Get latitude and longitude from geo data
    $latitudeFrom = $outputFrom->results[0]->geometry->location->lat;
    $longitudeFrom = $outputFrom->results[0]->geometry->location->lng;

    $latitudeTo = $outputTo->results[0]->geometry->location->lat;
    $longitudeTo = $outputTo->results[0]->geometry->location->lng;

    $avoid = "";
    if ($avoidtolls == 'tolls') $avoid .= $avoidtolls;

    if ($avoidhightways == 'highways') {
        if ($avoid != "") $avoid .= "|" . $avoidhightways;
        else $avoid .= $avoidhightways;
    }
    //avoid=highways


    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $latitudeFrom . "," . $longitudeFrom . "&destinations=" . $latitudeTo . "," . $longitudeTo . "&mode=driving&avoid=" . $avoid;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
    $dist = $response_a['rows'][0]['elements'][0]['distance']['value'];
    $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    return $dist;


}

function generateRandomCode($length = 10)
{
    //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


///////////////////////////////////


function xlsBOF()
{
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
    return;
}

function xlsEOF()
{
    echo pack("ss", 0x0A, 0x00);
    return;
}

function xlsWriteNumber($Row, $Col, $Value)
{
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
    return;
}

function xlsWriteLabel($Row, $Col, $Value)
{
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
    return;
}

?>