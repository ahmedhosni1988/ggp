<?php


function check_mysql_string($mycon, $string)
{
    global $mycon;

    $string ="'".mysqli_real_escape_string($mycon, $string)."'";


    return $string;
}

function build_array($date_array)
{
    $category = array();
    while ($row = mysqli_fetch_assoc($date_array)) {
        foreach ($row as $key => $value) {
            $arr[$key] = $value;
        }
    
        $category[] =$arr;
    }
 
 
    return $category;
}



///make insert query //
function make_insert($table_name, $array)
{
    global $mycon;
    $sql = "";
    $sqlk = "";
    $sqlval = "";
    
    $sql = "insert into  ".$table_name;
    foreach ($array as $key => $value) {
        $sqlk .=  $key.',';
        $sqlval .= check_mysql_string($mycon, $value).',';
    }
    $s = $sql.'('.substr($sqlk, 0, strlen($sqlk)-1).') values ('.substr($sqlval, 0, strlen($sqlval)-1).');';


    if ($table_name == 'order_place_details') {
        if (isset($array['package_id']) && isset($array['order_status']) && $array['package_id'] > 0) {
            mysqli_query($mycon, "update orders_package set package_status = '".$array['order_status']."'  where id = '".$array['package_id']."'  ") or die(mysqli_error($mycon));
        }
    }

    return $s;
}
    
    ///make update///
    function make_update($table_name, $array, $updated_key, $updated_id)
    {
        global $mycon;

        $sql = "update ".$table_name."  set ";
        $sqlk = "";
        foreach ($array as $key => $value) {
            $sqlk .=  $key.'='.check_mysql_string($mycon, $value).' ,';
        }
    
        $s = $sql.' '.substr($sqlk, 0, strlen($sqlk)-1).' where '.$updated_key.' = '.check_mysql_string($mycon, $updated_id);
    
        return $s;
    }
