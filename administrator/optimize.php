<?php
include("../setting.php");
include("../classes/work.php");

$workClass = new work($db);

$wSheet = 3.21 * 2.25 ;

$_POST['from_date'] = '2022-02-01 00:00:00';
$_POST['to_date'] = '2022-02-02 00:00:00';

$result = $workClass->salesReportDetails($_POST);

array_multisort(array_column($result, "package_size"), SORT_DESC, $result);
//array_multisort(array_column($result, "length"), SORT_DESC, $result);
//array_multisort(array_column($result, "width"), SORT_DESC, $result);


///check min number os sheet

$sheetSQ = 0;
$mySheet = array();
$sheetCount = 1;
$parts = 0;
$squareParts = 0;
for ($i=0;$i<count($result);$i++) {
    if ($result[$i]['length'] < '322') {
        $parts++;
        $sheetSQ = $sheetSQ + ($result[$i]['package_size']);
    
        $squareParts = $squareParts + ($result[$i]['package_size']);
     
        if ($sheetSQ <= $wSheet) {
            $mySheet[$sheetCount][] = $result[$i];
        } else {
     
            ///check if their is other sheet
            if (count($mySheet) > 1) {
                $is_fit = check_fit($mySheet[$sheetCount], $result[$i], $wSheet);
                if ($is_fit) {
                    echo 'Fit';
                } else {
                    $sheetCount++;
                    $sheetSQ = ($result[$i]['package_size']);
                    $mySheet[$sheetCount][] = $result[$i];
                }
            } else {
                $sheetCount++;
                $sheetSQ = ($result[$i]['package_size']);
                $mySheet[$sheetCount][] = $result[$i];
            }
        }
    }
}


function check_fit($mysheet, $pices, $sheetSize)
{
    $squareParts = 0;
    for ($i=0;$i<count($mysheet);$i++) {
        $squareParts = $squareParts + ($mysheet[$i]['package_size']);
    }
    if (($sheetSize - $squareParts) >= $pices['package_size']) {
        return true;
    } else {
        return false;
    }
}
echo 'Sheet Number : '.$sheetCount.' For : '.$parts."<br>";
echo 'Square parts : '.$squareParts.'<br>';
echo 'Optimal Sheet : '.($squareParts / ($wSheet));

var_dump($mySheet);
// for ($s=1;$s< count($mySheet);$i++) {
//     echo '------------------------------<br>';
//     for ($j=0;$j<count($mySheet[$s]);$j++) {
//         echo $mySheet[$s][$j]['length'].'*'.$mySheet[$s][$j]['width'].'<br>';
//     }
//     echo '------------------------------<br>';
// }

//array_multisort(
//var_dump($result);
