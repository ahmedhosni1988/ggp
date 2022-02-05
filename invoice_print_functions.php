<?php
//******************************************************************************
//  Invoice Print             :  invoice_print_functions.php                   *
//                                                                             *
//  This module is included in:  invoice.php                                   *
//                               invoiceall.php                                *
//  This module is linked from:                                                *
//  This module links to      :                                                *
//                                                                             *
//  This module includes      :  none                                          *
//                                                                             *
//******************************************************************************
//ModLog:                                                                      *
//*******                                                                      *
//2005-09-21: Seperate customer "Bill-to" address if different                 *
//2005-10-03: bug: newpage was missing cellspacing setting...                  *
//                 this caused another inner border.                           *
//2005-10-11: new function for reference break subtotalling - used for print   *
//             format no 1 & 2.  Also included for final break before totals.  *
//******************************************************************************

function continuation_header($ppp)
{
    global $mtborder, $itborder, $co_name, $acctno, $invoiceno, $name;
    global $hrwidth, $inputfmbcs2_prt, $inputfmwcs2_prt, $inputfmc_prt, $inputfmnd_prt;
    $hlwidth = 210;
    $hmwidth = 180;
//* Header                                                             //*header
//*header titlebar                                                             *
    echo "<tr> <td " . $fmt_prt[0] . "  > <table border=$mtborder>";

//* header inner datacells                                                     *
//*header left                                                                 *
    echo "      <td width=$hlwidth> <table border=$itborder> ";
    showrow(array("Sold to: &nbsp;$acctno"), $inputfmnd_prt);
    showrow(array($name), $inputfmw_prt);
    echo "      </table> </td>";

//*header middle                                                               *
    echo " <td valign=center width=$hmwidth> <table border=$itborder> ";
    showrow(array($co_name), $inputfmwcs2_prt);
    showrow(array("Page", $ppp), $inputfmw_prt);
    echo " </table>                          </td>";

//*header right                                                                *
    echo "<td   align=right valign=top width=$hrwidth> <table border=$itborder> ";
    $iw = array();
    $iw[0] = 190;
    $bar = array();
    $bar[0] = " I N V O I C E ";
    $size = array();
    $size[0] = 3;
    printrow_console_header_dark($bar, $iw, $size, $inputfmbcs2_prt);
    showrow(array("رقم الفاتورة", $invoiceno), $inputfmnd_prt);
    echo "       </table> </td>";

    echo " </table> </td> </tr>";
//* Header                                                             //*header
    return $pageno;
}

function lineitem_header()
{
    global $mtborder, $lineitem_hdr, $cw, $fmts;
    echo " <tr> <td > <table border=$mtborder>";
    $size = array();
    $size[0] = 1;
    $size[1] = 1;
    $size[2] = 1;
    $size[3] = 1;
    $size[4] = 1;
    $size[5] = 1;
    $size[6] = 1;
    $size[7] = 1; //textsize - always small for header.
    $size[8] = 1;
    $size[9] = 1;
    $size[10] = 1;
    $size[11] = 1;
    $size[12] = 1;
    $size[13] = 1;
    printrow_console_header($lineitem_hdr, $cw, $size, $fmts[0]);
    echo " </table> </td> </tr> ";
}

function messageline($msg)
{
    global $mtborder, $inputfmnd_prt;
    if (trim($msg) != "") {
        echo "  <tr>   <td align=center bgcolor=f4f4f4> <table border=$mtborder>";     //*table:for the message
        showrow(array($msg), $inputfmnd_prt);
        echo " </table> </td> </tr>";                                        //*table:for the message
    }
}

function newpage($prm)
{
    global $mtborder, $otborder, $ospacing, $fmt_prt, $otw;
    global $lc;
    $pg = $prm[0];
    $mxl = $prm[1];
    $pg++;
    if ($pg == 2) $mxl = $mxl + $prm[2];
    //* first, close off inner & outer tables
    echo " </table> </td> </tr>";                                           //*inner
    echo "</table> ";                                                       //*outer
    //*skip to new page
    echo "<h6> &nbsp; </h6>";   //  cause a page-break
    //showrow (array("<br>...$lc...<br>"),"");
    //showrow(array("Pageeeeeee ",$pg."...".$mx),$inputfmw_prt );

    //* reopen inner & outer tables & do cont' headers.
    echo "<table border=$otborder cellspacing=$ospacing width=$otw>";       //*outer
    continuation_header($pg);
    lineitem_header();
    echo "<tr> <td " . $fmt_prt[0] . "  > <table border=$mtborder>";            //*inner
    $prm[0] = $pg;
    $prm[1] = $mxl;
    return $prm;
}

//* Place <br>'s in a string to force width to fit in a column.
function fieldwrap($z, $w, $method)
{
    $z = html_entity_decode($z);                       //Step1: get the length as what will actually print
    $z = str_replace("\x0D\x0A", " ", $z);              //Step2: remove CR/LF
    $len = strlen($z);
    $z = $z . " ";

    //*Adjust width($w) if they have a lot of CAPS
    // assume the CAPS are evenly distributed thru $z.
    $numcaps = 0;
    for ($n = 0; $n < $len; $n++) {
        if (substr($z, $n, 1) >= "A" and substr($z, $n, 1) <= "Z") $numcaps++;
    }
    if ($numcaps > 0) $capspart = $w / $numcaps;
    //*Lets try assuming with CAPS - a fit of about 80% (in the same space as lower)
    // so just knock 20% of the no of CAPS chars off $w
    // first, adjust numcaps by an estimate(rough) of the number that will be in each line
    if ($len > $w)
        $x = ceil($len / $w);
    else
        $x = 1;
    $w = $w - ceil($numcaps / $x * 0.2);

    $cnt = ceil($len / $w);

    $r = $z;
    if ($cnt > 1) {
        //No Wrap - chop.
        if ($method == 1) {
            $r = "";
            for ($n = 0; $n < $cnt; $n++) {
                $r .= substr($z, $n * $w, $w);
                if ($n < $cnt - 1) $r .= "<br>";
            }
        }
        //Wrap words.
        if ($method > 1) {
            $z = $z . " ";
            $r = "";

            //first, lets make sure we have no words wider than the column
            $newz = "";
            while (trim($z) != "") {
                if (trim($z) != "") {
                    $z = ltrim($z);
                    $p = strpos($z, " ");
                    if ($p > $w) $p = $w;
                    $newz .= substr($z, 0, $p) . " ";
                    $z = substr($z, $p);                //echo "+++$z"."+++$p+++<br><br>";
                }
            }
            $z = str_replace("  ", " ", $newz);

            for ($n = 0; $n < $cnt; $n++) {
                $x = substr($z, 0, $w);
                $lastblank = strrpos($x, " ");
                $r .= substr($x, 0, $lastblank);
                if ($n < $cnt - 1)
                    $r .= "<br>";
                $z = substr($z, $lastblank);
            }
            //May have some leftovers - ie:what may split on to 2 lines, may need 3 to wrap.
            if (trim($z) != "")
                $r .= "<br>" . $z;
        }

    }
    return $r;
    //return $r."*".$orgw."*".$numcaps."*".$w."*";  //++++++++++++++++++++++
}

//* Determine how many lines this field will print on
function countlines($fld)
{
    $cnt = 0;
    while (strpos($fld, "<br>") > 0):
        $cnt = $cnt + 1;
        $fld = substr_replace($fld, "    ", strpos($fld, "<br>"), 4);
    endwhile;
    $count = $cnt + 1;
    return $count;
}

//* Break on reference Code.
function reference_break($n)
{
    global $option_fs_on_lines, $option_tax_on_lines, $option_sortby_ref;
    global $ref, $prev_ref, $prev2_ref, $subtotal;
    global $li_chgtype, $li_waybill_refs, $cw, $size, $inputfm_invoiceline_prt;
//* Subtotal on break on reference code.
//*                                    *
//* logic: since sorted by ref - all blank refs will come first
//* "M" type lines - not an issue - since they can't have refs
//* So.. we look for "S" type records ONLY.
//* THE PLAN: we only want a subtotal if > 1 waybill with same ref.
//* remember; each waybill can have up to 3 lineitems.
//*
    if ($option_sortby_ref == "Y" and $li_chgtype[$n] == "S") {
        $ref = strtoupper(trim($li_waybill_refs[$n]));
        //* we need at least 2 of the same ref to do a subtotal
        if ($prev_ref != "" and $prev_ref != $ref and $prev_ref == $prev2_ref) {
            //* Doing the SubTotal.
            $subline = array();
            $subline[0] = "";
            $subline[1] = "";
            $subline[2] = "<b>" . "Reference: " . $prev_ref . "</b>";
            $subline[3] = "<b>" . sprintf("%01.2f", $subtotal[amt]) . "</b>";
            //show F.S.
            if ($option_fs_on_lines == "Y") {
                $subline[4] = "<b>" . sprintf("%01.2f", $subtotal[fs]) . "</b>";
                $subline[5] = "<b>" . sprintf("%01.2f", $subtotal[amt] + $subtotal[fs]) . "</b>";
            }
            //show Taxes
            if ($option_tax_on_lines == "Y") {
                $subline[3] = "<b>" . sprintf("%01.2f", $subtotal[amt] + $subtotal[fs]) . "</b>";
                $subline[4] = "<b>" . sprintf("%01.2f", $subtotal[tax]) . "</b>";
                $subline[5] = "<b>" . sprintf("%01.2f", $subtotal[amt] + $subtotal[fs] + $subtotal[tax]) . "</b>";
            }
            //show both, f.s. & taxes
            if ($option_fs_on_lines == "Y" and $option_tax_on_lines == "Y") {
                $subline[3] = "<b>" . sprintf("%01.2f", $subtotal[amt]) . "</b>";
                $subline[4] = "<b>" . sprintf("%01.2f", $subtotal[fs]) . "</b>";
                $subline[5] = "<b>" . sprintf("%01.2f", $subtotal[amt] + $subtotal[fs]) . "</b>";
                $subline[6] = "<b>" . sprintf("%01.2f", $subtotal[tax]) . "</b>";
                $subline[7] = "<b>" . sprintf("%01.2f", $subtotal[amt] + $subtotal[fs] + $subtotal[tax]) . "</b>";
            }
            showrow_line($subline, $cw, $size, $inputfm_invoiceline_prt);
        }
        if ($ref != $prev_ref) $subtotal = array();
        $prev2_ref = strtoupper($prev_ref);
        $prev_ref = strtoupper($ref);
    } //if ($option_sortby_ref == "Y"  and  $li_chgtype[$n] == "S")
} //function

?>
