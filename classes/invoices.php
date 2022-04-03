<?php

class invoices
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }


    public function calcInvoise($order_id)
    {
        
                       /////////////////// ahmed reda  add invoise/////////////////////////////


        $invcount =  0;
        $wbcount  =  0;
        $cocount  =  0;

        $order = 0;
        $out_order = 0;
        $query = "";

        $query = mysqli_query($this->db, "select orders_package.*,account.account_id,account.account_name from orders_package
                       inner join orders on (orders.order_id = orders_package.order_id) 
                       inner join account on (account.account_id = orders.account_id) 
                       where orders_package.invoice_no = 0 and orders_package.order_id = '".$order_id."' ") or die(mysqli_error($this->db));
                   
        $order = 1;

        if (mysqli_num_rows($query) > 0) {
                        

                        ///shoud check if invoiced before or not
            $packageList = $package->get_package_id();
            $statusList = $db->get_table_by_id("status", "id", "statusname");
            $price_list = array();
            $q = mysqli_query($this->db, "select * from package_status_price where account_id = 0") or die(mysqli_error($this->db));
            while ($r = mysqli_fetch_array($q)) {
                $price_list[$r['package_id']][$r['status_id']] = $r['fee'];
            }


            while ($row = mysqli_fetch_array($query)) {

    //var_dump($row);
                ///cala
    
                $meter = $row['length'] * $row['width'] / 10000;
    
    
                // echo $row['order_status']."<br>";
    
                $m = explode(',', $row['order_status']);
                //var_dump($m);
                for ($j =0 ;$j<count($m);$j++) {
                    if ($m[$j] != "5" && $m[$j] != "6") {
                        $price = $price_list[$row['package_type']][$m[$j]];
                        $pactotal = $price * $meter;
    
                        mysqli_query($this->db, "insert into orders_price (order_id,package_id,price,type,name,ratio) 
            values ('".$row['order_id']."','".$row['id']."','".$pactotal."','".$m[$j]."','".$statusList[$m[$j]]."','".$meter."');") or die(mysqli_error($this->db));
                    }
                }
            }


            $query = mysqli_query($this->db, "select orders_package.*,account.account_id,account.account_name from orders_package
    inner join orders on (orders.order_id = orders_package.order_id) 
    inner join account on (account.account_id = orders.account_id) 
    where orders_package.invoice_no = 0 and orders_package.order_id = '".$order_id."' ") or die(mysqli_error($this->db));

            $order = 1;

            $row = mysqli_fetch_array($query);
            $invhdr = array();
            $invhdr["clid"]          = $row["account_id"];
            $invhdr["acctno"]        = $row["account_name"];
            $invhdr["date"]          = date("Y-m-d");
            $invoiceno = $invoices->insert_invoice($invhdr);
        
            $invcount = $invcount + 1;
        

            $query = mysqli_query($this->db, "select orders_package.*,account.account_id,account.account_name from orders_package
        inner join orders on (orders.order_id = orders_package.order_id) 
        inner join account on (account.account_id = orders.account_id) 
        where orders_package.invoice_no = 0 and orders_package.order_id = '".$order_id."' ") or die(mysqli_error($this->db));
    
            $order = 1;


        
            $lineno = 0;
            while ($nrow = mysqli_fetch_array($query)) {
                $order_inv_prices = $price->get_inv_order_prices($nrow["id"]);

                $services_charges = setup_serviceprices($order_inv_prices, $add_ser, $nrow);

                $detailrec = array();
                $detailrec["clid"]          = $nrow["account_id"];
                $detailrec["acctno"]        = $nrow["account_name"];
                $detailrec["invoiceno"]     = $invoiceno;
                $detailrec["waybill"]       = $nrow["id"];
                $detailrec["waybill_ref"]   = $nrow["chargecode"];
                $detailrec["item"]          = $nrow["easy_order_id"].'-'.$nrow['part_order'];
   
 
   
                for ($sc = 0; $sc < count($services_charges); $sc++) {
                    $detailrec["lineno"]        = $lineno;
        
                    //  $txcalcs = tax_fs_calc($customer["account_taxgroup"],$fsrate,$services_charges[$sc]["chg"],$services_charges[$sc]["typ"]);
                    $detailrec["amount"]        = sprintf("%01.2f", round($services_charges[$sc]["chg"], 2));
        

                    $detailrec["chgtype"]       = $services_charges[$sc]["typ"];
        
  
                    $detailrec["descn"] = $services_charges[$sc]["des"];

                    //* SQL - Save the Invoice Detail Record.
                    $invoicedet = $invoices->insert_invoicedetails($detailrec);
        

                    $lineno = $lineno + 1;
                    $subtotal = $subtotal + $detailrec["amount"];
        
                    mysqli_query($this->db, "update orders_package set invoice_no = '".$invoiceno."' where id = '".$nrow['id']."' ");
                }
                $wbcount++;

                // var_dump($services_charges);
            }

            $invhdr["id"]          = $invoiceno;
            $invhdr["subtotal"]    = $subtotal;

            $invhdr["printed"]     = "N";
            $invhdr["delivered"]   = "N";
            $invhdr["posted"]      = "N";
            $invhdr["paid"]        = "N";
            $invhdr["source"]      = "W";
            $invhdr["message"]     = $c_setting["co_invoice_message"];
            $invoices->update_invoice($invoiceno, $invhdr);

            $or = mysqli_query($this->db, "select * from orders where 1=1 order by order_id ");
        }

        /////////////////// end ahmed reda /////////////////////////////
    }



    public function re_calc_order_invoice($order_id, $account_id = '')
    {
        mysqli_query($this->db, "delete from orders_price where order_id = '".$order_id."' ");


        $query = mysqli_query($this->db, "select orders_package.*,account.account_id,account.account_name,orders.invoice_no from orders_package
        inner join orders on (orders.order_id = orders_package.order_id) 
        inner join account on (account.account_id = orders.account_id) 
        where orders_package.order_id = '".$order_id."' ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) < 1) {
          
          //  echo "noooooooooooo";
            $ret['error'] = "1";
            $ret['msg'] = "لا توجد قطع" ;
            

            $q = mysqli_query($this->db, "select invoice_no from orders where order_id ='".$order_id."'") or die(mysqli_error($this->db));
           
            while ($r = mysqli_fetch_array($q)) {
                $invoice_no = $r['invoice_no'];
            }

            mysqli_query($this->db, "delete from invoicedtl where invoiceno = '".$invoice_no."' ") or die(mysqli_error($this->db));

            $invhdr["id"]          = $invoice_no;
            $invhdr["subtotal"]    = 0;
            $invhdr["reviewed"]    = 0;

            $this->update_invoice($invoice_no, $invhdr);

            return $ret;
        }
        //echo " yessssss ";

        $packageList = $this->db->get_table_by_id_all("package_type", "package_id");
        $statusList = $this->db->get_table_by_id("status", "disporder", "statusname");
        $price_list = array();

        $q = mysqli_query($this->db, "select * from package_status_price where account_id = 0 ") or die(mysqli_error($this->db));
        while ($r = mysqli_fetch_array($q)) {
            $price_list[$r['package_id']][$r['status_id']] = $r['fee'];
        }
        
        if ($account_id != '') {
            $q = mysqli_query($this->db, "select * from package_status_price where account_id = '$account_id' ") or die(mysqli_error($this->db));
            while ($r = mysqli_fetch_array($q)) {
                $price_list[$r['package_id']][$r['status_id']] = $r['fee'];
            }
        }


        ///////////set orders_price /////////
        while ($row = mysqli_fetch_array($query)) {

            //var_dump($row);
            ///cala
            
            $meter = $row['length'] * $row['width'] / 10000;
            
            
            // echo $row['order_status']."<br>";
            
            $m = explode(',', $row['order_status']);
            //var_dump($m);
            for ($j =0 ;$j<count($m);$j++) {
                if ($m[$j] != "6" && $m[$j] != "7") {
                    $price = $price_list[$row['package_type']][$m[$j]];
                    
                    $pactotal = $price * $meter;
            
                    mysqli_query($this->db, "insert into orders_price (order_id,package_id,price,type,name,ratio) 
                    values ('".$row['order_id']."','".$row['id']."','".$pactotal."','".$m[$j]."','".$statusList[$m[$j]]."','".$meter."');") or die(mysqli_error($this->db));
                }
            }
        }
        ////// end orders_price///////////
        $q = mysqli_query($this->db, "select invoice_no from orders where order_id ='".$order_id."'") or die(mysqli_error($this->db));
           
        while ($r = mysqli_fetch_array($q)) {
            $invoice_no = $r['invoice_no'];
        }

        mysqli_query($this->db, "delete from invoicedtl where invoiceno = '".$invoice_no."' ") or die(mysqli_error($this->db));


        $query = mysqli_query($this->db, "select orders_package.*,account.account_id,account.account_name from orders_package
            inner join orders on (orders.order_id = orders_package.order_id) 
            inner join account on (account.account_id = orders.account_id) 
            where  orders_package.order_id = '".$order_id."' ") or die(mysqli_error($this->db));
        
        $Pack_options=$this->get_Pack_options();
        $pack_type=$this->get_package_type();
            
        ////////////invoi_detil /////////////////
        $lineno = 0;
        while ($nrow = mysqli_fetch_array($query)) {
            $order_inv_prices = $this->get_inv_order_prices($nrow["id"]);

            $services_charges = setup_serviceprices($order_inv_prices, $add_ser, $nrow, $pack_type, $Pack_options);

            $detailrec = array();
            $detailrec["clid"]          = $nrow["account_id"];
            $detailrec["acctno"]        = $nrow["account_name"];
            $detailrec["invoiceno"]     = $invoice_no;
            $detailrec["waybill"]       = $nrow["id"];
            $detailrec["waybill_ref"]   = $nrow["chargecode"];
            $detailrec["item"]          = $nrow["easy_order_id"].'-'.$nrow['part_order'];
   
 
   
            for ($sc = 0; $sc < count($services_charges); $sc++) {
                $detailrec["lineno"]        = $lineno;
        
                //  $txcalcs = tax_fs_calc($customer["account_taxgroup"],$fsrate,$services_charges[$sc]["chg"],$services_charges[$sc]["typ"]);
                $detailrec["amount"]        = sprintf("%01.2f", round($services_charges[$sc]["chg"], 2));
        

                $detailrec["chgtype"]       = $services_charges[$sc]["typ"];
        
  
                $detailrec["descn"] = $services_charges[$sc]["des"];

                //* SQL - Save the Invoice Detail Record.
                $invoicedet = $this->insert_invoicedetails($detailrec);
        
                ////////////end  invoi_detil /////////////////
                $lineno = $lineno + 1;
                $subtotal = $subtotal + $detailrec["amount"];
        
                mysqli_query($this->db, "update orders_package set invoice_no = '".$invoice_no."' where id = '".$nrow['id']."' ");
            }
            $wbcount++;

            // var_dump($services_charges);
        }

        $invhdr["id"]          = $invoice_no;
        $invhdr["subtotal"]    = $subtotal;

        $this->update_invoice($invoice_no, $invhdr);

        ////

        $ret['error'] = "0";
        $ret['msg'] = "تم اعادة حساب الفاتورة" ;
        return $ret;
    }

    public function get_Pack_options($account_id=0)
    {
        $query = mysqli_query($this->db, "select * from addtional_services  where account_id=$account_id") or die(mysqli_error($this->db));
        $arr = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $arr[$row['id']] = $row['name'];
        }

        return $arr;
    }

    public function get_package_type()
    {
        $query = mysqli_query($this->db, "select * from package_type") or die(mysqli_error($this->db));
        $arr = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $arr[$row['package_id']] = $row['package_name'];
        }

        return $arr;
    }
    public function new_re_calc_order_invoice($order_id, $account_id = '')
    {
        mysqli_query($this->db, "delete from orders_price where order_id = '".$order_id."' ");


        $query = mysqli_query($this->db, "select orders.price_version_account_id ,orders.price_version_system_id  , orders_package.*,account.account_id,account.account_name,orders.invoice_no from orders_package
    inner join orders on (orders.order_id = orders_package.order_id) 
    inner join account on (account.account_id = orders.account_id) 
    where orders_package.order_id = '".$order_id."' ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) < 1) {
      
      //  echo "noooooooooooo";
            $ret['error'] = "1";
            $ret['msg'] = "لا توجد قطع" ;
        

            $q = mysqli_query($this->db, "select invoice_no from orders where order_id ='".$order_id."'") or die(mysqli_error($this->db));
       
            while ($r = mysqli_fetch_array($q)) {
                $invoice_no = $r['invoice_no'];
            }

            mysqli_query($this->db, "delete from invoicedtl where invoiceno = '".$invoice_no."' ") or die(mysqli_error($this->db));

            $invhdr["id"]          = $invoice_no;
            $invhdr["subtotal"]    = 0;
            $invhdr["reviewed"]    = 0;

            $this->update_invoice($invoice_no, $invhdr);

            return $ret;
        }
        $price_version_account_id='' ;
        $price_version_system_id='' ;

        $query3 = mysqli_query($this->db, "select price_version_account_id ,price_version_system_id  from orders  where  orders.order_id = '".$order_id."'") or die(mysqli_error($this->db));

        while ($r = mysqli_fetch_array($query3)) {
            $price_version_account_id = $r['price_version_account_id'];
            $price_version_system_id = $r['price_version_system_id'];
            break;
        }
    
        $packageList = $this->db->get_table_by_id_all("package_type", "package_id");
        $statusList = $this->db->get_table_by_id("status", "disporder", "statusname");
        $price_list = array();
        $addtional_services =array();
        $q = mysqli_query($this->db, "select * from package_status_price where account_id = 0  and version_id='$price_version_system_id'") or die(mysqli_error($this->db));
        while ($r = mysqli_fetch_array($q)) {
            $price_list[$r['package_id']][$r['status_id']] = $r['fee'];
        }
    
        if ($account_id != '') {
            $q = mysqli_query($this->db, "select * from package_status_price where account_id = '$account_id' and version_id='$price_version_account_id'") or die(mysqli_error($this->db));
            while ($r = mysqli_fetch_array($q)) {
                $price_list[$r['package_id']][$r['status_id']] = $r['fee'];
            }
        }
    
        ////////////// addtional addtional_services ////////////////////////
        if ($account_id != '') {

        // $q = mysqli_query($this->db,"select `addtional_services`.`pack_id`,`addtional_services`.`per_meters`,`addtional_services`.`name`,`addtional_services`.`short_name` , `pack`.`id` as account_pack_id,pack.price , pack.account_id from addtional_services inner join pack on( `pack`.`addtional_services_id` = `addtional_services`.`id`) where pack.account_id= '$account_id' ") or die (mysqli_error($this->db));
            $q = mysqli_query($this->db, "select `addtional_services`.id as pack_id,`addtional_services`.`per_meters`,`addtional_services`.`name`,`addtional_services`.`short_name` , `pack`.`id` as id,pack.price , pack.account_id from addtional_services inner join pack on( `pack`.`addtional_services_id` = `addtional_services`.`id`) where pack.account_id=$account_id") or die(mysqli_error($this->db));
            $qResult=array();
            while ($r = mysqli_fetch_array($q)) {
                $qResult[]= $r;
            }
        }
        $q = mysqli_query($this->db, "select * from addtional_services where account_id = 0 ") or die(mysqli_error($this->db));
        while ($r = mysqli_fetch_array($q)) {
            $addtional_services[$r['id']] = $r['price'];
            for ($j = 0; $j < count($qResult); $j++) {
                if ($qResult[$j]['pack_id'] ==  $r['id']) {
                    $addtional_services[$r['id']] = $qResult[$j]['price'];
                }
            }
        }
    
        ////////////// addtional addtional_services ////////////////////////

        /////////// ahmed reda //

    
        ///////////set orders_price /////////
        mysqli_query($this->db, "delete from orders_price where order_id = '".$order_id."' ");

        while ($row = mysqli_fetch_array($query)) {

        //var_dump($row);
            ///cala
        
            $meter = $row['length'] * $row['width'] / 10000;
        
        
            // echo $row['order_status']."<br>";
        
            $m = explode(',', $row['order_status']);
            //var_dump($m);
            for ($j =0 ;$j<count($m);$j++) {
                if ($m[$j] != "6" && $m[$j] != "7") {
                
                    //$price = $price_list[$row['package_type']][$m[$j]];

                    if (isset($price_list[$row['package_type']][$m[$j]][$row['glasscolour']][$row['glassType']])) {
                        $price = $price_list[$row['package_type']][$m[$j]][$row['glasscolour']][$row['glassType']];
                    } elseif (isset($price_list[$row['package_type']][$m[$j]][$row['glasscolour']]['1'])) {
                        $price = $price_list[$row['package_type']][$m[$j]][$row['glasscolour']]['1'];
                    } elseif (isset($price_list[$row['package_type']][$m[$j]]['1']['1'])) {
                        $price = $price_list[$row['package_type']][$m[$j]]['1']['1'];
                    }


                    ////////////// addtional addtional_services ////////////////////////
                    $ad = explode(',', $row['pack_options']);
                    for ($x =0 ;$x<count($ad);$x++) {
                        $price= $price +$addtional_services[$ad[$x]];
                    }
                    ////////////// addtional addtional_services ////////////////////////
                    $pactotal = $price * $meter;
        
                    mysqli_query($this->db, "insert into orders_price (order_id,package_id,price,type,name,ratio) 
                values ('".$row['order_id']."','".$row['id']."','".$pactotal."','".$m[$j]."','".$statusList[$m[$j]]."','".$meter."');") or die(mysqli_error($this->db));
                }
            }
        }
        ////// end orders_price///////////
        $q = mysqli_query($this->db, "select invoice_no from orders where order_id ='".$order_id."'") or die(mysqli_error($this->db));
           
        while ($r = mysqli_fetch_array($q)) {
            $invoice_no = $r['invoice_no'];
        }

        mysqli_query($this->db, "delete from invoicedtl where invoiceno = '".$invoice_no."' ") or die(mysqli_error($this->db));


        $query = mysqli_query($this->db, "select orders_package.*,account.account_id,account.account_name from orders_package
        inner join orders on (orders.order_id = orders_package.order_id) 
        inner join account on (account.account_id = orders.account_id) 
        where orders_package.order_id = '".$order_id."' ") or die(mysqli_error($this->db));
        $Pack_options=$this->get_Pack_options();
        $pack_type=$this->get_package_type();
        // print_r($Pack_options);
        // print_r($pack_type);
        ////////////invoi_detil /////////////////
        $lineno = 0;
        while ($nrow = mysqli_fetch_array($query)) {
            // print_r($nrow);
            $order_inv_prices = $this->get_inv_order_prices($nrow["id"]);
            // $x='الطول :'.$nrow['length'].' , العرض : '.$nrow['width'].' , السمك : '.$pack_type[$nrow['package_type']].' , الخدمة : '.$pack_type[$nrow['pack_options']];

            $services_charges = setup_serviceprices($order_inv_prices, $add_ser, $nrow, $pack_type, $Pack_options);
        
            $detailrec = array();
            $detailrec["clid"]          = $nrow["account_id"];
            $detailrec["acctno"]        = $nrow["account_name"];
            $detailrec["invoiceno"]     = $invoice_no;
            $detailrec["waybill"]       = $nrow["id"];
            $detailrec["waybill_ref"]   = $nrow["chargecode"];
            $detailrec["item"]          = $nrow["easy_order_id"].'-'.$nrow['part_order'];
           
         
           
            for ($sc = 0; $sc < count($services_charges); $sc++) {
                $detailrec["lineno"]        = $lineno;
                
                //  $txcalcs = tax_fs_calc($customer["account_taxgroup"],$fsrate,$services_charges[$sc]["chg"],$services_charges[$sc]["typ"]);
                $detailrec["amount"]        = sprintf("%01.2f", round($services_charges[$sc]["chg"], 2));
                
        
                $detailrec["chgtype"]       = $services_charges[$sc]["typ"];
                
          
                $detailrec["descn"] = $services_charges[$sc]["des"];
        
                //* SQL - Save the Invoice Detail Record.
                $invoicedet = $this->insert_invoicedetails($detailrec);
                
                ////////////end  invoi_detil /////////////////
                $lineno = $lineno + 1;
                $subtotal = $subtotal + $detailrec["amount"];
                
                mysqli_query($this->db, "update orders_package set invoice_no = '".$invoice_no."' where id = '".$nrow['id']."' ");
            }
            $wbcount++;
        
            // var_dump($services_charges);
        }
        
        $invhdr["id"]          = $invoice_no;
        $invhdr["subtotal"]    = $subtotal;
        $invhdr["reviewed"]    = 0;
        $this->update_invoice($invoice_no, $invhdr);
        /////////////end update $invhdr
    }


    public function create_order_invoice($order_id, $account_id = '')
    {

        //echo "ahmed";
        $query = mysqli_query($this->db, "select orders.price_version_account_id ,orders.price_version_system_id  ,
        orders_package.*,account.account_id,account.account_name,
        orders.invoice_no from orders_package
        inner join orders on (orders.order_id = orders_package.order_id) 
        inner join account on (account.account_id = orders.account_id) 
        where orders_package.order_id = '".$order_id."'") or die(mysqli_error($this->db));
      
       
        $price_version_account_id='' ;
        $price_version_system_id='' ;
       
        if ($query == "" || mysqli_num_rows($query) < 1) {
            //    echo "del".$order_id;
            $ret['error'] = "1";
            $ret['msg'] = "لا توجد قطع" ;
            return $ret;
        }
      
        $query3 = mysqli_query($this->db, "select price_version_account_id ,price_version_system_id  from orders  where  orders.order_id = '".$order_id."'") or die(mysqli_error($this->db));

        while ($r = mysqli_fetch_array($query3)) {
            $price_version_account_id = $r['price_version_account_id'];
            $price_version_system_id = $r['price_version_system_id'];
            break;
        }
        // / hsht'l fe el 7eta hnaked'


        $packageList = $this->db->get_table_by_id_all("package_type", "package_id");
        $statusList = $this->db->get_table_by_id("status", "disporder", "statusname");
        $price_list = array();
        $addtional_services =array();
        // echo "select * from package_status_price where account_id = 0  and version_id='$price_version_system_id'";

        $q = mysqli_query($this->db, "select * from package_status_price where account_id = 0  and version_id='$price_version_system_id'") or die(mysqli_error($this->db));
        while ($r = mysqli_fetch_array($q)) {
            $price_list[$r['package_id']][$r['status_id']][$r['item_colour']][$r['Glass_type']] = $r['fee'];
        }
        //echo 'ahmed';
        if ($account_id != '') {
            // echo "select * from package_status_price where account_id = '$account_id' and version_id='$price_version_system_id' ";
            $q = mysqli_query($this->db, "select * from package_status_price where account_id = '$account_id' and version_id='$price_version_system_id' ") or die(mysqli_error($this->db));
            while ($r = mysqli_fetch_array($q)) {
                $price_list[$r['package_id']][$r['status_id']][$r['item_colour']][$r['Glass_type']] = $r['fee'];
            }
        }


        // echo 'ahmed';
        if ($account_id != '') {
            // echo "select * from package_status_price where account_id = '$account_id' and version_id='$price_version_system_id' ";
            $q = mysqli_query($this->db, "select * from package_status_price where account_id = '$account_id' and version_id='$price_version_account_id' ") or die(mysqli_error($this->db));
            while ($r = mysqli_fetch_array($q)) {
                $price_list[$r['package_id']][$r['status_id']][$r['item_colour']][$r['Glass_type']] = $r['fee'];
            }
        }
        
        ////////////// addtional addtional_services ////////////////////////

        $q = mysqli_query($this->db, "select * from addtional_services where account_id = 0 ") or die(mysqli_error($this->db));
        while ($r = mysqli_fetch_array($q)) {
            $addtional_services[$r['id']] = $r;
            // for ($j = 0; $j < count($qResult); $j++) {
            //     if($qResult[$j]['pack_id'] ==  $r['id'] ){
            //         $addtional_services[$r['id']] = $qResult[$j];
            //     }
            // }
        }

        if ($account_id != '') {

            // $q = mysqli_query($this->db,"select `addtional_services`.`pack_id`,`addtional_services`.`per_meters`,`addtional_services`.`name`,`addtional_services`.`short_name` , `pack`.`id` as account_pack_id,pack.price , pack.account_id from addtional_services inner join pack on( `pack`.`addtional_services_id` = `addtional_services`.`id`) where pack.account_id= '$account_id' ") or die (mysqli_error($this->db));
            $q = mysqli_query($this->db, "select addtional_services.* , `addtional_services`.id as pack_id,`addtional_services`.`per_meters`,`addtional_services`.`name`,`addtional_services`.`short_name` , `pack`.`id` as id,pack.price , pack.account_id from addtional_services 
            inner join pack on( `pack`.`addtional_services_id` = `addtional_services`.`id`) where pack.account_id=$account_id") or die(mysqli_error($this->db));
            $qResult=array();
            while ($r = mysqli_fetch_array($q)) {
                $addtional_services[$r['id']] = $r;
            }
        }

        
        ////////////// addtional addtional_services ////////////////////////

        /////////// ahmed reda //

        
        //var_dump($price_list);
        ///////////set orders_price /////////
        mysqli_query($this->db, "delete from orders_price where order_id = '".$order_id."' ");

        while ($row = mysqli_fetch_array($query)) {

            //var_dump($row);
            ///cala
            
            $meter = $row['length'] * $row['width'] / 10000;
            
            
            // echo $row['order_status']."<br>";
            
            $m = explode(',', $row['order_status']);
            //var_dump($m);
            for ($j =0 ;$j<count($m);$j++) {
                $price = 0;
                if ($m[$j] != "6" && $m[$j] != "7") {
                    if (isset($price_list[$row['package_type']][$m[$j]][$row['glasscolour']][$row['glassType']])) {
                        $price = $price_list[$row['package_type']][$m[$j]][$row['glasscolour']][$row['glassType']];
                    } elseif (isset($price_list[$row['package_type']][$m[$j]][$row['glasscolour']]['1'])) {
                        $price = $price_list[$row['package_type']][$m[$j]][$row['glasscolour']]['1'];
                    } elseif (isset($price_list[$row['package_type']][$m[$j]]['1']['1'])) {
                        $price = $price_list[$row['package_type']][$m[$j]]['1']['1'];
                    }


                    //$price = $price_list[$row['package_type']][$m[$j]];
                    
       
                    ////////////// addtional addtional_services ////////////////////////
                    $pactotal = $price * $meter;
            
                    mysqli_query($this->db, "insert into orders_price (order_id,package_id,price,type,name,ratio) 
                    values ('".$row['order_id']."','".$row['id']."','".$pactotal."','".$m[$j]."','".$statusList[$m[$j]]."','".$meter."');") or die(mysqli_error($this->db));
                }
            }


            ////////////// addtional addtional_services ////////////////////////
            $ad = explode(',', $row['pack_options']);
            for ($x =0 ;$x<count($ad);$x++) {
                $permeter =  $addtional_services[$ad[$x]]['per_meters'];
                $paramter = "";
                $cprice = '';
                if ($permeter == "1") {
                    $paramter =     $row['length'] +  $row['width'] + $row['length'] +  $row['width'] ;
                    $paramter = $paramter / 100;

                    $cprice =  $addtional_services[$ad[$x]]['price'] * $paramter;
                }
                if ($permeter == "2") {
                    $paramter = $meter;
                    $cprice =  $addtional_services[$ad[$x]]['price'] * $meter;
                }
                if ($permeter == "0") {
                    $paramter = $meter;
                    $cprice =  $addtional_services[$ad[$x]]['price'] ;
                }
                mysqli_query($this->db, "insert into orders_price (order_id,package_id,price,type,name,ratio) 
                    values ('".$row['order_id']."','".$row['id']."','".$cprice."','add_".$addtional_services[$ad[$x]]['id']."','".$addtional_services[$ad[$x]]['name']."','".$paramter."');") or die(mysqli_error($this->db));
                  
                //$price = $price + $addtional_services[$ad[$x]];
            }
        }
        ////// end orders_price///////////


        /////////set invic_head ////////

        $query = mysqli_query($this->db, "select orders_package.*,account.account_id,account.account_name,
            orders.invoice_no from orders_package
            inner join orders on (orders.order_id = orders_package.order_id) 
            inner join account on (account.account_id = orders.account_id) 
            where  orders_package.order_id = '".$order_id."'") or die(mysqli_error($this->db));

        $row = mysqli_fetch_array($query);

        $invhdr = array();
        $invhdr["clid"]          = $row["account_id"];
        $invhdr["acctno"]        = $row["account_name"];
        $invhdr["order_id"]      = $row["order_id"];
        $invhdr["easy_order_id"]      = $row["easy_order_id"];

        if ($row['invoice_no'] == '0') {
            $invhdr["date"]          =  date("Y-m-d");
            $invhdr["system_date"]          =  date("Y-m-d H:i:s");

            $invoiceno = $this->insert_invoice($invhdr);
        } else {
            $invoiceno = $row['invoice_no'];
            $invhdr['reviewed'] = '0';

            $this->update_invoice($invoiceno, $invhdr);
        }

        $invcount = $invcount + 1;


        $query = mysqli_query($this->db, "select orders_package.*,account.account_id,account.account_name from orders_package
            inner join orders on (orders.order_id = orders_package.order_id) 
            inner join account on (account.account_id = orders.account_id) 
            where  orders_package.order_id = '".$order_id."' ") or die(mysqli_error($this->db));
           
        $Pack_options=$this->get_Pack_options();
        $pack_type=$this->get_package_type();
        // print_r($Pack_options);
        mysqli_query($this->db, "delete from invoicedtl where invoiceno = '".$invoiceno."' ");

        // print_r($pack_type);
        ////////////invoi_detil /////////////////
        $lineno = 0;
        while ($nrow = mysqli_fetch_array($query)) {
            // print_r($nrow);
            $order_inv_prices = $this->get_inv_order_prices($nrow["id"]);
            // $x='الطول :'.$nrow['length'].' , العرض : '.$nrow['width'].' , السمك : '.$pack_type[$nrow['package_type']].' , الخدمة : '.$pack_type[$nrow['pack_options']];

            $services_charges = setup_serviceprices($order_inv_prices, $add_ser, $nrow, $pack_type, $Pack_options);
            
            $detailrec = array();
            $detailrec["clid"]          = $nrow["account_id"];
            $detailrec["acctno"]        = $nrow["account_name"];
            $detailrec["invoiceno"]     = $invoiceno;
            $detailrec["waybill"]       = $nrow["id"];
            $detailrec["waybill_ref"]   = $nrow["chargecode"];
            $detailrec["item"]          = $nrow["easy_order_id"].'-'.$nrow['part_order'];
               
             
               
            for ($sc = 0; $sc < count($services_charges); $sc++) {
                $detailrec["lineno"]        = $lineno;
                    
                //  $txcalcs = tax_fs_calc($customer["account_taxgroup"],$fsrate,$services_charges[$sc]["chg"],$services_charges[$sc]["typ"]);
                $detailrec["amount"]        = sprintf("%01.2f", round($services_charges[$sc]["chg"], 2));
                    
            
                $detailrec["chgtype"]       = $services_charges[$sc]["typ"];
                    
              
                $detailrec["descn"] = $services_charges[$sc]["des"];
            
                //* SQL - Save the Invoice Detail Record.
                $invoicedet = $this->insert_invoicedetails($detailrec);
                    
                ////////////end  invoi_detil /////////////////
                $lineno = $lineno + 1;
                $subtotal = $subtotal + $detailrec["amount"];
                    
                mysqli_query($this->db, "update orders_package set invoice_no = '".$invoiceno."' where id = '".$nrow['id']."' ");
            }
            $wbcount++;
            
            // var_dump($services_charges);
        }
            
        $invhdr["id"]          = $invoiceno;
        $invhdr["subtotal"]    = $subtotal;
        //$invhdr["prepaid"]     = 0;
        $invhdr["printed"]     = "N";
        $invhdr["delivered"]   = "N";
        $invhdr["posted"]      = "N";
        $invhdr["paid"]        = "N";
        $invhdr["source"]      = "W";
        $invhdr["message"]     = $c_setting["co_invoice_message"];
        if ($invoiceno > 0) {
            $invhdr['reviewed'] = '0';
        }
        $this->update_invoice($invoiceno, $invhdr);

          
        
        ////// end invice_head /////////


        /////////  orders update /////////////

        $ordupd["invoice_no"] = $invoiceno;

        $sql = $this->db->make_update("orders", $ordupd, "order_id", $order_id);

  
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
  
        if ($query) {
            return true;
        }

        /////////  end orders update /////////////

            

////////end ahmed reda //////
    }

    public function get_inv_order_prices($order_id)
    {
        $query = mysqli_query($this->db, "select * from orders_price where package_id = " . check_mysql_string($this->db,$order_id) . " ") or die(mysqli_error($this->db));
        $order_details = array();
        $i = 0;
        while ($row = mysqli_fetch_assoc($query)) {
            $order_details[$i][$row["type"]] = $row;
            $i++;
        }
        return $order_details;
    }


    public function insert_invoice($array)
    {
        $sql = $this->db->make_insert("invoicehdr", $array);


        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }


    public function insert_invoicedetails($array)
    {
        $sql = $this->db->make_insert("invoicedtl", $array);


        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }

    public function get_process_invoices($offset, $no_of_records_per_page, $billing_code, $reviewed=0)
    {
        $msql = "";
        if ($billing_code > "1") {
            $msql = " and (account.billing_code = '".$billing_code."' or orders.billing_code = '".$billing_code."' ) ";
        }

        // $sql = "select *,account_company as company, (invoicehdr.subtotal + invoicehdr.fsamount + invoicehdr.tax2amount + invoicehdr.tax1amount + invoicehdr.tax3amount + invoicehdr.tax4amount) as invoice_total
        // from invoicehdr
        // inner join account on (invoicehdr.clid = account.account_id)
        //  where  invoicehdr.paid <> 'Y' and invoicehdr.printed <> 'Y' and invoicehdr.delivered <> 'Y'  and invoicehdr.reviewed=$reviewed  order by invoicehdr.id";

        $sql="select `orders`.`order_size`,`orders`.`pieces`,`orders`.`price_version_account_id`,`orders`.`price_version_system_id`,account.*,invoicehdr.*,account_company as company, 
(invoicehdr.subtotal + invoicehdr.fsamount + invoicehdr.tax2amount + invoicehdr.tax1amount + invoicehdr.tax3amount + invoicehdr.tax4amount)
 as invoice_total , orders.order_type , orders.order_status from invoicehdr 
 inner join orders on (`orders`.`order_id` = `invoicehdr`.`order_id`) 
 inner join account on (invoicehdr.clid = account.account_id) 
 where invoicehdr.paid <> 'Y' and invoicehdr.printed <> 'Y'
  and invoicehdr.delivered <> 'Y' and invoicehdr.reviewed=$reviewed  $msql order by invoicehdr.id desc LIMIT $offset, $no_of_records_per_page";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        $company_details = array();


        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $company_details[] = $arr;
        }


        return $company_details;
    }


    public function get_open_invoice($account_id, $invoice_no, $due_date, $billingcode, $from = '', $to = '')
    {
        $sql = "";

        if ($invoice_no != "") {
            $sql .= " and invoicehdr.id = " . check_mysql_string($this->db,$invoice_no) . " ";
        } else {
            if ($account_id != "") {
                $sql .= " and invoicehdr.clid = " . check_mysql_string($this->db,$account_id) . " ";
            }
            if ($due_date != "") {
                $sql .= " and invoicehdr.duedate <= " . check_mysql_string($this->db,$due_date) . " ";
            }
            if ($billingcode != "") {
                $sql .= " and account.billing_code <= " . check_mysql_string($this->db,$billingcode) . " ";
            }
            if ($from != '') {
                $sql .= " and invoicehdr.date >= " . check_mysql_string($this->db,$due_date) . " ";
            }
            if ($to != '') {
                $sql .= " and invoicehdr.date <= " . check_mysql_string($this->db,$due_date) . " ";
            }
        }

        $query = mysqli_query($this->db, "select invoicehdr.id,clid,invoicehdr.acctno,date,duedate,random,fsamount,tax1amount,tax2amount,tax3amount,tax4amount,tax5amount,subtotal,account_company as company, (invoicehdr.subtotal + invoicehdr.fsamount + invoicehdr.tax2amount + invoicehdr.tax1amount+ invoicehdr.tax3amount+ invoicehdr.tax4amount) as invoice_total  from invoicehdr,account where invoicehdr.clid=account.account_id and paid<>'Y'  " . $sql . " order by invoicehdr.acctno,invoicehdr.date,invoicehdr.id") or die(mysqli_error($this->db));

        $category = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $q = mysqli_query($this->db, "select * from cashreceipts where invoiceno='" . $row['id'] . "' ") or die(mysqli_error($this->db));
            $payments = 0;
            for ($i = 0; $i < mysqli_num_rows($q); $i++) {
                $cashrcpt = mysqli_fetch_assoc($q);
                $payments = $payments + $cashrcpt["applied"];
            }

            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }
            $arr['payments'] = sprintf("%01.2f", $payments);

            $category[] = $arr;
        }

        return $category;
    }

    public function get_cash_recipt($account_id, $invoice_no, $due_date)
    {
        $sql = "";

        if ($account_id != "") {
            $sql .= " and invoicehdr.clid = " . check_mysql_string($this->db,$account_id) . " ";
        }
        if ($invoice_no != "") {
            $sql .= " and invoicehdr.id = " . check_mysql_string($this->db,$invoice_no) . " ";
        }
        if ($due_date != "") {
            $sql .= " and invoicehdr.duedate <= " . check_mysql_string($this->db,$due_date) . " ";
        }


        $query = mysqli_query($this->db, "select cashreceipts.id,
               clid,
               cashreceipts.acctno,
               ref,
               link,
               date,
               paymethod,
               pymt_amount,
               ppd,
               invoiceno,
               applied
        from cashreceipts,account where cashreceipts.clid=account.account_id  and date >= '2013-07-01' and date <= '2013-07-31'
        order by date asc, acctno, ref asc, invoiceno asc") or die(mysqli_error($this->db));

        return $this->db->build_array($query);
    }


    public function create_invoice_header($invoice_details)
    {
        $sql = $this->db->make_insert("invoicehdr", $invoice_details);

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        return mysqli_insert_id($this->db);
    }


    public function get_invoice_header($invoice_id)
    {
        $query = mysqli_query($this->db, "select * from invoicehdr where id=" . check_mysql_string($this->db,$invoice_id) . "") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query)) {
            $row = mysqli_fetch_object($query);
            return $row;
        } else {
            return false;
        }
    }


    public function get_invoice_lines($invoice_id)
    {
        $query = mysqli_query($this->db, "select * from invoicedtl LEFT  outer join orders on (orders.order_id = invoicedtl.item ) where invoicedtl.invoiceno=" . check_mysql_string($this->db,$invoice_id) . " order by lineno") or die(mysqli_error($this->db));


        $company_details = array();


        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $company_details[] = $arr;
        }


        return $company_details;
    }


    public function search_invoices($invoice_id, $from_date, $to_date, $account_id)
    {
        $query = mysqli_query($this->db, "select * from invoicehdr  LEFT  outer join cashreceipts  on (cashreceipts.invoiceno = invoicehdr.id ) where invoicehdr.id =" . check_mysql_string($this->db,$invoice_id) . " and invoicehdr.clid = " . check_mysql_string($this->db,$account_id) . " ") or die(mysqli_error($this->db));


        $company_details = array();


        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $company_details[] = $arr;
        }


        return $company_details;
    }


    public function update_invoice($invoice_id, $array)
    {
        $sql = $this->db->make_update("invoicehdr", $array, "id", $invoice_id);

        //echo $sql;

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }

    public function insert_cash($array)
    {
        $sql = $this->db->make_insert("cashreceipts", $array);


        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }


    public function get_account_byinvoice_id($account_id)
    {
        $query = mysqli_query($this->db, "select clid from invoicehdr where id = '" . $account_id . "' ") or die(mysqli_error($this->db));
        $row = mysqli_fetch_array($query);

        return $row['clid'];
    }


    public function cancel_invoices($invoice_id)
    {
        $query = mysqli_query($this->db, "select order_id from orders where invoiceno = '$invoice_id'") or die(mysqli_error($this->db));

        $ids = "";
        while ($row = mysqli_fetch_array($query)) {
            mysqli_query($this->db, "update orders set invoiceno = '0' where order_id = '" . $row['order_id'] . "' ") or die(mysqli_error($this->db));
        }


        mysqli_query($this->db, "delete from invoicedtl where invoiceno = '$invoice_id'");
        mysqli_query($this->db, "delete from invoicehdr where id = '$invoice_id'");
    }


    public function get_cash_receipt($data)
    {
        $sql = "";
        if (isset($data['account_id']) && $data['account_id'] != '') {
            $sql .= " and cashreceipts.clid='" . $data['account_id'] . "' ";
        }
        if (isset($data['client']) && $data['client'] != '*') {
            $sql .= " and cashreceipts.clid='" . $data['client'] . "' ";
        }
        if (isset($data['billingcode']) && $data['billingcode'] != '*') {
            $sql .= " and account.clid='" . $data['billingcode'] . "' ";
        }
        if (isset($data['invoice_no']) && $data['invoice_no'] != '') {
            $sql .= " and cashreceipts.invoiceno='" . $data['invoice_no'] . "' ";
        }
        if (isset($data['from_invoice_date']) && $data['from_invoice_date'] != '') {
            $sql .= " and cashreceipts.date >='" . $data['from_invoice_date'] . "' ";
        }
        if (isset($data['to_invoice_date']) && $data['to_invoice_date'] != '') {
            $sql .= "  and cashreceipts.date <= '" . $data['to_invoice_date'] . "' ";
        }

        $where = "select cashreceipts.id,
	account.account_company,
	cashreceipts.clid,
	account.account_name as acctno,
	cashreceipts.ref,
	cashreceipts.link,
	cashreceipts.date,
	cashreceipts.paymethod,
	cashreceipts.pymt_amount,
	cashreceipts.ppd,
	cashreceipts.invoiceno,
	cashreceipts.applied,
	invoicehdr.subtotal,
	invoicehdr.fsamount,
	invoicehdr.tax2amount,
	invoicehdr.tax1amount,
	invoicehdr.tax3amount,
	invoicehdr.tax4amount
	from cashreceipts 
	inner join invoicehdr on (invoicehdr.id = cashreceipts.invoiceno)
	inner join account on (cashreceipts.clid=account.account_id)   where (cashreceipts.clid=account.account_id)  $sql
	order by   invoiceno asc";

        //echo $where;
        $q = mysqli_query($this->db, $where) or die(mysqli_error($this->db));

        //echo $where;
        $category = array();

        while ($row = mysqli_fetch_assoc($q)) {
            $inv_total = "";
            $query = mysqli_query($this->db, "select (invoicehdr.subtotal + invoicehdr.fsamount + invoicehdr.tax2amount + invoicehdr.tax1amount + invoicehdr.tax3amount + invoicehdr.tax4amount) as invoice_total from invoicehdr where id = '" . $row['invoiceno'] . "' ") or die(mysqli_error($this->db));
            if (mysqli_num_rows($query) > 0) {
                $r = mysqli_fetch_array($query);
                $inv_total = $r['invoice_total'];
            }

            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }
            $arr['invoice_total'] = $inv_total;
            $category[] = $arr;
        }


        return $category;
    }


    public function get_cash_receipt_deposit($data)
    {
        $sql = "";
        if (isset($data['account_id']) && $data['account_id'] != '') {
            $sql .= " and cashreceipts.clid='" . $data['account_id'] . "' ";
        }
        if (isset($data['client']) && $data['client'] != '*') {
            $sql .= " and cashreceipts.clid='" . $data['client'] . "' ";
        }
        if (isset($data['billingcode']) && $data['billingcode'] != '*') {
            $sql .= " and account.billing_code='" . $data['billingcode'] . "' ";
        }
        if (isset($data['invoiceno']) && $data['invoiceno'] != '') {
            $sql .= " and cashreceipts.invoiceno='" . $data['invoiceno'] . "' ";
        }
        if (isset($data['from_invoice_date']) && $data['from_invoice_date'] != '') {
            $sql .= " and cashreceipts.date >='" . $data['from_invoice_date'] . "' ";
        }
        if (isset($data['to_invoice_date']) && $data['to_invoice_date'] != '') {
            $sql .= "  and cashreceipts.date <= '" . $data['to_invoice_date'] . "' ";
        }
        //if(isset($data['due_date']) && $data['due_date'] != '' ) $sql .=  "  and cashreceipts.date >= '".$data['to_invoice_date']."' ";

        $where = "select cashreceipts.acctno,applied from cashreceipts,account where
          (cashreceipts.acctno=account.account_name) $sql
        	order by cashreceipts.acctno";


        //echo $where;

        $q = mysqli_query($this->db, $where) or die(mysqli_error($this->db) . "test");

        $deposits = array();
        //*get all cashreceipts for all customers(or just one) - against invoice no Zero,
        // & put in array.
        for ($n = 0; $n < mysqli_num_rows($q); $n++) {
            $cr = mysqli_fetch_assoc($q);
            $acctno = $cr["acctno"];
            $applied = $cr["applied"];
            $deposits["$acctno"] = $deposits["$acctno"] + $applied;

            //$xxx = $deposits["$acctno"];                        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            //echo "$acctno ...  $applied ...  $xxx <br><br>";    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        }

        return $deposits;
    }


    public function get_unpaid_invoices($account_id)
    {
        $sql = "select *,(invoicehdr.subtotal + invoicehdr.fsamount + invoicehdr.tax2amount + invoicehdr.tax1amount + invoicehdr.tax3amount + invoicehdr.tax4amount) as invoice_total  from invoicehdr where paid<>'Y'  and clid='$account_id' order by id";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        $category = array();

        while ($row = mysqli_fetch_assoc($query)) {
            $payments = "";
            $rc = mysqli_query($this->db, "select * from cashreceipts where invoiceno='" . $row['id'] . "' and clid='$account_id'") or die(mysqli_errno($this->db));
            for ($i = 0; $i < mysqli_num_rows($rc); $i++) {
                $cashrcpt = mysqli_fetch_assoc($rc);
                $payments = $payments + $cashrcpt["applied"];
            }

            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $arr['payments'] = $payments;
            $category[] = $arr;
        }


        $r = mysqli_query($this->db, "select * from cashreceipts where invoiceno='0' and clid='$account_id'") or die(mysqli_errno($this->db));
        $payments = 0;
        for ($i = 0; $i < mysqli_num_rows($r); $i++) {
            $cashrcpt = mysqli_fetch_assoc($r);
            $payments = $payments + $cashrcpt["applied"];
        }
        if (mysqli_num_rows($r) > 0) {
            $category[] = array('id' => '0', 'invoiceno' => '0', 'payments' => $payments);
        }
        return $category;
    }


    public function rebuild_aged_invoice($invoices, $date)
    {
        if (count($invoices) > 0) {
            for ($i = 0; $i < count($invoices); $i++) {

                //
            }
        }
    }

    public function get_invoice($data)
    {
        $sql = "";

        $sql = "";
        if (isset($data['client']) && $data['client'] != '') {
            $sql .= " and invoicehdr.clid='" . $data['client'] . "' ";
        }
        if (isset($data['billingcode']) && $data['billingcode'] != '*') {
            $sql .= " and account.billing_code='" . $data['billingcode'] . "' ";
        }
        if (isset($data['invoice_no']) && $data['invoice_no'] != '') {
            $sql .= " and invoicehdr.id='" . $data['invoice_no'] . "' ";
        }
        //if (isset($data['invoice_date_form']) && $data['invoice_date_form'] != '' && $data['invoice_no'] == "") $sql .= " and invoicehdr.date >='" . $data['invoice_date_form'] . "' ";
        if (isset($data['reviewed']) && $data['reviewed'] != '') {
            $sql .= "  and invoicehdr.reviewed = '" . $data['reviewed'] . "' ";
        }
        if (isset($data['billing_code']) && $data['billing_code'] != '') {
            $sql .= " and account.billing_code='" . $data['billing_code'] . "' ";
        }
        if (isset($data['invoice_date_form']) && $data['invoice_date_form'] != '' && isset($data['invoice_date_to']) && $data['invoice_date_to'] != '') {
            $sql .= " and invoicehdr.date BETWEEN '" . $data['invoice_date_form'] . "' AND '".$data['invoice_date_to']."' ";
        }

        //	echo $sql;
        $query = mysqli_query($this->db, "select orders.office_name,orders.operation_name,`orders`.`order_size`,`orders`.`pieces`,`orders`.`price_version_account_id`,`orders`.`price_version_system_id`,account.*,invoicehdr.*,account_company as company, 
        (invoicehdr.subtotal + invoicehdr.fsamount + invoicehdr.tax2amount + invoicehdr.tax1amount + invoicehdr.tax3amount + invoicehdr.tax4amount)
         as invoice_total , orders.order_type , orders.order_status 
        from invoicehdr 
        left join orders on (`orders`.`order_id` = `invoicehdr`.`order_id`) 
        inner join account on (invoicehdr.clid = account.account_id) 
        where invoicehdr.clid=account.account_id   " . $sql . " order by invoicehdr.date ASC, id ASC") or die(mysqli_error($this->db));

        $category = array();
        while ($row = mysqli_fetch_assoc($query)) {
            $q = mysqli_query($this->db, "select * from cashreceipts where invoiceno='" . $row['id'] . "' ") or die(mysqli_error($this->db));
            $payments = 0;
            for ($i = 0; $i < mysqli_num_rows($q); $i++) {
                $cashrcpt = mysqli_fetch_assoc($q);
                $payments = $payments + $cashrcpt["applied"];
            }

            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }
            $arr['payments'] = sprintf("%01.2f", $payments);

            $category[] = $arr;
        }

        return $category;
    }


    public function bulid_aged_report($invoices, $date)
    {
        $reuslt = array();
        $currentValue = 0;

        if (count($invoices) > 0) {
            $reuslt['acctno'] = $invoices[0]['acctno'];
            $reuslt['clid'] = $invoices[0]['clid'];
            $reuslt['acctno'] = $invoices[0]['acctno'];

            for ($i = 0; $i < count($invoices); $i++) {

                //echo $i."-".date('Y-m-d',strtotime($date. ' - 90 days'))."<br>";

                //	echo $invoices[$i]['duedate']."<br>";
                if ($invoices[$i]['invoice_total'] - $invoices[$i]['payments'] >= 0) {


                    //More than 90 days
                    if (strtotime($invoices[$i]['duedate']) <= strtotime($date . ' - 60 days')) {
                        $days90 += ($invoices[$i]['invoice_total'] - $invoices[$i]['payments']);
                    }

                    //first month
                    if (strtotime($invoices[$i]['duedate']) <= strtotime($date . ' - 30 days') && strtotime($invoices[$i]['duedate']) > strtotime($date . ' - 60 days')) {
                        $days60 += ($invoices[$i]['invoice_total'] - $invoices[$i]['payments']);
                    }


                    if (strtotime($invoices[$i]['duedate']) <= strtotime($date) && strtotime($invoices[$i]['duedate']) > strtotime($date . ' - 30 days')) {
                        $days30 += ($invoices[$i]['invoice_total'] - $invoices[$i]['payments']);
                    }

                    if (strtotime($invoices[$i]['duedate']) > strtotime($date)) {
                        //echo $invoices[$i]['duedate'];
                        $current += ($invoices[$i]['invoice_total'] - $invoices[$i]['payments']);
                    }

                    $total += ($invoices[$i]['invoice_total'] - $invoices[$i]['payments']);
                }
            }


            $reuslt['90'] = $days90;
            $reuslt['60'] = $days60;
            $reuslt['30'] = $days30;
            $reuslt['current'] = $current;
            $reuslt['total'] = $total;

            return $reuslt;
        } else {
            return false;
        }
    }


    public function get_paid_invoice($from, $to)
    {
        if ($from != '') {
            $sql .= " and invoicehdr.date >= " . check_mysql_string($this->db,$from) . " ";
        }
        if ($to != '') {
            $sql .= " and invoicehdr.date <= " . check_mysql_string($this->db,$to) . " ";
        }

        //echo "select *  from invoicehdr where  paid = 'Y'   ".$sql." ";

        $query = mysqli_query($this->db, "select *  from invoicehdr where  paid = 'Y'   " . $sql . " ") or die(mysqli_error($this->db));

        return mysqli_num_rows($query);
    }


    
    public function get_account_company($account_id)
    {
        $query = mysqli_query($this->db, "select * from account where account_id = " . $account_id . "") or die(mysqli_error($this->db));
        if (mysqli_num_rows($query) == 1) {
            $row = mysqli_fetch_array($query);
            return $row['account_company'];
        } else {
            return false;
        }
    }
}
