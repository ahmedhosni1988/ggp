<?php

class package
{
    public $db;

    public function package($db)
    {
        $this->db = $db;
    }


    public function get_package()
    {
        $query = mysql_query("select * from  package_type order by package_order ASC ") or die(mysql_error());

        $pack = array();
        $i = 0;
        while ($row = mysql_fetch_array($query)) {
            $pack[$i] = array('package_id' => $row['package_id'], 'package_name' => $row['package_name'], 'package_short' => $row['package_short']);
            $i++;
        }

        return $pack;
    }

    public function get_package_id()
    {
        $query = mysql_query("select * from  package_type order by package_order ASC ") or die(mysql_error());

        $pack = array();
        $i = 0;
        while ($row = mysql_fetch_array($query)) {
            $pack[$row['package_id']] = $row;
            $i++;
        }

        return $pack;
    }

    public function get_package_vechile()
    {
        $query = mysql_query("select * from  package_type order by package_id ASC ") or die(mysql_error());

        $pack = array();
        $i = 0;
        while ($row = mysql_fetch_array($query)) {
            $pack[$i] = array('package_id' => $row['package_id'], 'package_name' => $row['package_name']);
            $i++;
        }

        return $pack;
    }
    public function edit_item(
        $id,
        $number,
        $otype,
        $order_id,
        $weight,
        $volume,
        $details,
        $parts,
        $pac_type,
        $pac_status,
        $glasscolour,
        $glassPrint,
        $glassType,
        $glassScarch,
        $glassPointing,
        $glassFixedPointing,
        $noofprinting,
        $colorofprinting,
        $account_id
    ) {
        global $h, $cpCount;

        // var_dump($pac_status);
        $pac_status=implode(",", $pac_status);
        // echo $pac_status;
        $query = mysql_query("UPDATE orders_package set
    order_id=" . $this->db->qstr($order_id) . ", 
    service_id=" . $this->db->qstr($otype) . ",
     length=" . $this->db->qstr($weight) . ",
     width=" . $this->db->qstr($volume) . ", 
     details=" . $this->db->qstr($details) . ", 
     parts=" . $this->db->qstr($parts) . ",
     package_type=" . $this->db->qstr($pac_type) . ",
     order_status=" . $this->db->qstr($pac_status) . ", 
     glasscolour=" . $this->db->qstr($glasscolour) . ",
     glassPrint=" . $this->db->qstr($glassPrint) . ",
     glassType=" . $this->db->qstr($glassType) . ",
     glassScarch=" . $this->db->qstr($glassScarch) . ",
     glassPointing=" . $this->db->qstr($glassPointing) . ",
     glassFixedPointing=" . $this->db->qstr($glassFixedPointing) . ",
     noofprinting=" . $this->db->qstr($noofprinting) . ",
     colorofprinting= " . $this->db->qstr($colorofprinting) . "
     WHERE orders_package.id=".$id. "") or die(mysql_error());
    }
    public function add_package(
        $number,
        $otype,
        $order_id,
        $easy_order,
        $weight,
        $volume,
        $details,
        $details_2,
        $parts,
        $pac_type,
        $pac_status,
        $glasscolour,
        $glassPrint,
        $glassType,
        $glassScarch,
        $glassPointing,
        $glassFixedPointing,
        $noofprinting,
        $colorofprinting,
        $pac_options,
        $pac_options_meters,
        $account_id
    ) {
        global $h, $cpCount;
        if ($otype == "1") {
            $sql="INSERT INTO orders_package(
                order_id, 
                service_id,
                 length,
                 width, 
                 details, 
                 details_2,
                 parts,
                 package_type,
                 order_status,
                 glasscolour,
                 glassPrint,
                 glassType,
                 glassScarch,
                 glassPointing,
                 glassFixedPointing,
                 noofprinting,
                 colorofprinting
                 ) VALUES 
            (". $this->db->qstr($order_id) . ",
            " . $this->db->qstr($otype) . ",
            " . $this->db->qstr($weight) . ",
            " . $this->db->qstr($volume) . ",
            " . $this->db->qstr($details) . ",
            " . $this->db->qstr($details_2) . ",
            " . $this->db->qstr($parts) . ",
            " . $this->db->qstr($pac_type) . ",
            " . $this->db->qstr($pac_status) . ",
            " . $this->db->qstr($glasscolour) . ",
            " . $this->db->qstr($glassPrint) . ",
            " . $this->db->qstr($glassType) . ",
            " . $this->db->qstr($glassScarch) . ",
            " . $this->db->qstr($glassPointing) . ",
            " . $this->db->qstr($glassFixedPointing) . ",
            " . $this->db->qstr($noofprinting) . ",
            " . $this->db->qstr($colorofprinting) . "
            )";
            echo $sql;

            $query = mysql_query($sql) or die(mysql_error());

            $id = mysql_insert_id();

            //$barcode = $account_id.'-'.$order_id.'-'.$id;

            $barcode = $order_id . '00' . $id;
            $update = mysql_query("update orders_package set barcode = '" . $barcode . "' where id = '" . $id . "' ");
        } elseif ($otype == "2") {
            $parent_id = 0;
            for ($i = 1; $i < $parts + 1; $i++) {
                $status = "";
                foreach ($pac_status as $names) {
                    $status .= $names . ",";
                }
                $status = substr($status, 0, strlen($status) - 1);

                $packoptions = "";
                if (is_array($pac_options)) {
                    foreach ($pac_options as $nam) {
                        $packoptions .= $nam . ",";
                    }
                    $packoptions = substr($packoptions, 0, strlen($packoptions) - 1);
                }
              

                $query = mysql_query("INSERT INTO orders_package(
				order_id, 
                easy_order_id,
				service_id,
				length,
				 width, 
				 details,
                 details_2, 
				 parts,
				 package_type,
				 order_status,
                 pack_options,
				 glasscolour,
				 glassPrint,
				 glassType,
				 glassScarch,
				 glassPointing,
				 glassFixedPointing,
				 noofprinting,
				 colorofprinting,
			     part_order
				 ) VALUES 
            (" . $this->db->qstr($order_id) . ",
            " . $this->db->qstr($easy_order) . ",
			" . $this->db->qstr($otype) . ",
			" . $this->db->qstr($weight) . ",
			" . $this->db->qstr($volume) . ",
			" . $this->db->qstr($details) . ",
            " . $this->db->qstr($details_2) . ",
			'1',
			" . $this->db->qstr($pac_type) . ",
            " . $this->db->qstr($status) . ",
            " . $this->db->qstr($packoptions) . ",
			" . $this->db->qstr($glasscolour) . ",
			" . $this->db->qstr($glassPrint) . ",
			" . $this->db->qstr($glassType) . ",
			" . $this->db->qstr($glassScarch) . ",
			" . $this->db->qstr($glassPointing) . ",
			" . $this->db->qstr($glassFixedPointing) . ",
			" . $this->db->qstr($noofprinting) . ",
			" . $this->db->qstr($colorofprinting) . ",
			'" . ($cpCount) . "'
			)") or die(mysql_error());

                $id = mysql_insert_id();

                if ($i == 1) {
                    $parent_id = $id;
                }

                $res[] = array('id'=>$id,'cpCount'=>$cpCount);

                $barcode = $order_id . '00' . $id;
                $cpCount++;
                $update = mysql_query("update orders_package set barcode = '" . $barcode . "' , parent_id = '".($i == 1 ? 0 : $parent_id)."'  where id = '" . $id . "' ");
            }
        }


        if ($query) {
            return $res;
        } else {
            return false;
        }
    }

    public function update_package($order_id, $weight, $volume, $details, $parts, $account_id, $pac_id)
    {
        $result = mysql_query("SELECT max(id) as id FROM orders_package") or die(mysql_error());

        if (!$result) {
            die('Could not query:' . mysql_error());
        }

        $id = mysql_fetch_array($result);

        $barcode = $order_id . '00' . $id['id'];

        $query = mysql_query("INSERT INTO orders_package(order_id, weight, volume, details, parts,barcode) VALUES (" . $this->db->qstr($order_id) . "," . $this->db->qstr($weight) . "," . $this->db->qstr($volume) . "," . $this->db->qstr($details) . "," . $this->db->qstr($parts) . "," . $this->db->qstr($barcode) . ")") or die(mysql_error());


        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function delete_order_package($order_id)
    {
        $query = mysql_query("delete from orders_package  where order_id = " . $this->db->qstr($order_id) . " ") or die(mysql_error());

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function delete_package($id)
    {
        $query = mysql_query("delete from package_type where package_id = '$id'  ") or die(mysql_error());
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    public function delete_item($id)
    {
        $query = mysql_query("delete from orders_package where id = '$id'  ") or die(mysql_error());
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function get_item($id)
    {
        $query = mysql_query("select *  from orders_package where id = '$id'  ") or die(mysql_error());
        if ($query) {
            return mysql_fetch_array($query, MYSQL_ASSOC);
        } else {
            return false;
        }
    }
    public function get_packages($id)
    {
        $query = mysql_query("select * from  package_type where package_id = '$id' ") or die(mysql_error());

        $pack = array();
        $pack = mysql_fetch_object($query);

        return $pack;
    }


    public function edit_package($id, $name, $shortname)
    {
        $query = mysql_query("update package_type set package_name = " . $this->db->qstr($name) . ", package_short = " . $this->db->qstr($shortname) . " where package_id = " . $this->db->qstr($id) . " ") or die(mysql_error());

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function add_pack_type($name, $shortname)
    {
        $query = mysql_query("insert into package_type ( package_name ,package_short) values(" . $this->db->qstr($name) . ", " . $this->db->qstr($shortname) . ");  ") or die(mysql_error());

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}
