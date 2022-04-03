<?php

class package
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }


    public function get_package()
    {
        $query = mysqli_query($this->db, "select * from  package_type order by package_order ASC ") or die(mysqli_error($this->db));

        $pack = array();
        $i = 0;
        while ($row = mysqli_fetch_array($query)) {
            $pack[$i] = array('package_id' => $row['package_id'], 'package_name' => $row['package_name'], 'package_short' => $row['package_short']);
            $i++;
        }

        return $pack;
    }

    public function get_package_id()
    {
        $query = mysqli_query($this->db, "select * from  package_type order by package_order ASC ") or die(mysqli_error($this->db));

        $pack = array();
        $i = 0;
        while ($row = mysqli_fetch_array($query)) {
            $pack[$row['package_id']] = $row;
            $i++;
        }

        return $pack;
    }

    public function get_package_vechile()
    {
        $query = mysqli_query($this->db, "select * from  package_type order by package_id ASC ") or die(mysqli_error($this->db));

        $pack = array();
        $i = 0;
        while ($row = mysqli_fetch_array($query)) {
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
        $query = mysqli_query($this->db, "UPDATE orders_package set
    order_id=" . check_mysql_string($this->db,$order_id) . ", 
    service_id=" . check_mysql_string($this->db,$otype) . ",
     length=" . check_mysql_string($this->db,$weight) . ",
     width=" . check_mysql_string($this->db,$volume) . ", 
     details=" . check_mysql_string($this->db,$details) . ", 
     parts=" . check_mysql_string($this->db,$parts) . ",
     package_type=" . check_mysql_string($this->db,$pac_type) . ",
     order_status=" . check_mysql_string($this->db,$pac_status) . ", 
     glasscolour=" . check_mysql_string($this->db,$glasscolour) . ",
     glassPrint=" . check_mysql_string($this->db,$glassPrint) . ",
     glassType=" . check_mysql_string($this->db,$glassType) . ",
     glassScarch=" . check_mysql_string($this->db,$glassScarch) . ",
     glassPointing=" . check_mysql_string($this->db,$glassPointing) . ",
     glassFixedPointing=" . check_mysql_string($this->db,$glassFixedPointing) . ",
     noofprinting=" . check_mysql_string($this->db,$noofprinting) . ",
     colorofprinting= " . check_mysql_string($this->db,$colorofprinting) . "
     WHERE orders_package.id=".$id. "") or die(mysqli_error($this->db));
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
            (". check_mysql_string($this->db,$order_id) . ",
            " . check_mysql_string($this->db,$otype) . ",
            " . check_mysql_string($this->db,$weight) . ",
            " . check_mysql_string($this->db,$volume) . ",
            " . check_mysql_string($this->db,$details) . ",
            " . check_mysql_string($this->db,$details_2) . ",
            " . check_mysql_string($this->db,$parts) . ",
            " . check_mysql_string($this->db,$pac_type) . ",
            " . check_mysql_string($this->db,$pac_status) . ",
            " . check_mysql_string($this->db,$glasscolour) . ",
            " . check_mysql_string($this->db,$glassPrint) . ",
            " . check_mysql_string($this->db,$glassType) . ",
            " . check_mysql_string($this->db,$glassScarch) . ",
            " . check_mysql_string($this->db,$glassPointing) . ",
            " . check_mysql_string($this->db,$glassFixedPointing) . ",
            " . check_mysql_string($this->db,$noofprinting) . ",
            " . check_mysql_string($this->db,$colorofprinting) . "
            )";
            echo $sql;

            $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

            $id = mysqli_insert_id($this->db);

            //$barcode = $account_id.'-'.$order_id.'-'.$id;

            $barcode = $order_id . '00' . $id;
            $update = mysqli_query($this->db, "update orders_package set barcode = '" . $barcode . "' where id = '" . $id . "' ");
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
              

                $query = mysqli_query($this->db, "INSERT INTO orders_package(
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
            (" . check_mysql_string($this->db,$order_id) . ",
            " . check_mysql_string($this->db,$easy_order) . ",
			" . check_mysql_string($this->db,$otype) . ",
			" . check_mysql_string($this->db,$weight) . ",
			" . check_mysql_string($this->db,$volume) . ",
			" . check_mysql_string($this->db,$details) . ",
            " . check_mysql_string($this->db,$details_2) . ",
			'1',
			" . check_mysql_string($this->db,$pac_type) . ",
            " . check_mysql_string($this->db,$status) . ",
            " . check_mysql_string($this->db,$packoptions) . ",
			" . check_mysql_string($this->db,$glasscolour) . ",
			" . check_mysql_string($this->db,$glassPrint) . ",
			" . check_mysql_string($this->db,$glassType) . ",
			" . check_mysql_string($this->db,$glassScarch) . ",
			" . check_mysql_string($this->db,$glassPointing) . ",
			" . check_mysql_string($this->db,$glassFixedPointing) . ",
			" . check_mysql_string($this->db,$noofprinting) . ",
			" . check_mysql_string($this->db,$colorofprinting) . ",
			'" . ($cpCount) . "'
			)") or die(mysqli_error($this->db));

                $id = mysqli_insert_id($this->db);

                if ($i == 1) {
                    $parent_id = $id;
                }

                $res[] = array('id'=>$id,'cpCount'=>$cpCount);

                $barcode = $order_id . '00' . $id;
                $cpCount++;
                $update = mysqli_query($this->db, "update orders_package set barcode = '" . $barcode . "' , parent_id = '".($i == 1 ? 0 : $parent_id)."'  where id = '" . $id . "' ");
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
        $result = mysqli_query($this->db, "SELECT max(id) as id FROM orders_package") or die(mysqli_error($this->db));

        if (!$result) {
            die('Could not query:' . mysqli_error($this->db));
        }

        $id = mysqli_fetch_array($result);

        $barcode = $order_id . '00' . $id['id'];

        $query = mysqli_query($this->db, "INSERT INTO orders_package(order_id, weight, volume, details, parts,barcode) VALUES (" . check_mysql_string($this->db,$order_id) . "," . check_mysql_string($this->db,$weight) . "," . check_mysql_string($this->db,$volume) . "," . check_mysql_string($this->db,$details) . "," . check_mysql_string($this->db,$parts) . "," . check_mysql_string($this->db,$barcode) . ")") or die(mysqli_error($this->db));


        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function delete_order_package($order_id)
    {
        $query = mysqli_query($this->db, "delete from orders_package  where order_id = " . check_mysql_string($this->db,$order_id) . " ") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function delete_package($id)
    {
        $query = mysqli_query($this->db, "delete from package_type where package_id = '$id'  ") or die(mysqli_error($this->db));
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
    public function delete_item($id)
    {
        $query = mysqli_query($this->db, "delete from orders_package where id = '$id'  ") or die(mysqli_error($this->db));
        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function get_item($id)
    {
        $query = mysqli_query($this->db, "select *  from orders_package where id = '$id'  ") or die(mysqli_error($this->db));
        if ($query) {
            return mysqli_fetch_assoc($query);
        } else {
            return false;
        }
    }
    public function get_packages($id)
    {
        $query = mysqli_query($this->db, "select * from  package_type where package_id = '$id' ") or die(mysqli_error($this->db));

        $pack = array();
        $pack = mysqli_fetch_object($query);

        return $pack;
    }


    public function edit_package($id, $name, $shortname)
    {
        $query = mysqli_query($this->db, "update package_type set package_name = " . check_mysql_string($this->db,$name) . ", package_short = " . check_mysql_string($this->db,$shortname) . " where package_id = " . check_mysql_string($this->db,$id) . " ") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function add_pack_type($name, $shortname)
    {
        $query = mysqli_query($this->db, "insert into package_type ( package_name ,package_short) values(" . check_mysql_string($this->db,$name) . ", " . check_mysql_string($this->db,$shortname) . ");  ") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}
