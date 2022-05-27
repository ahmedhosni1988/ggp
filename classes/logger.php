<?php
class logger
{
    public $db;
    // constructor function
    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }

    public function getAllLog($start =0, $perpage)
    {
        $query = mysqli_query($this->db, "select * from logs ORDER BY DATE DESC  limit ".$perpage." offset ".$start." ") or die(mysqli_error($this->db));
        $logs = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }
            $logs[] =$arr;
        }
        return $logs;
    }

    public function add_new_log($array)
    {
        $sql = make_insert("logs", $array);


        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }
    

    public function get_order_log($order_id)
    {
        $sql = "select * from logs where OBJECT_ID = '".$order_id."' and OBJECT_NAME = 'Order' and is_important = 1 ";
        $q = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

        if (mysqli_num_rows($q) > 0) {
            $result = build_array($q);
            return $result;
        } else {
            return false;
        }
    }

    public function get_log_count()
    {
        $query = mysqli_query($this->db, "select count(*) as num from logs  ") or die(mysqli_error($this->db));
        $r = mysqli_fetch_array($query);
        return $r['num'];
    }

    public function searchLog($oid, $oname, $uname, $start_date, $end_date, $start =0, $perpage, $order = 'DESC')
    {
        $where = "";
        $sql = "select * from logs  ";
        if (isset($oid) && !empty($oid)) {
            $where = "where";
            $sql .= $where . " OBJECT_ID = '".$oid."' ";
        }
        if (isset($uname) && !empty($uname)) {
            if ($where == "where") {
                $where = "and";
            } else {
                $where = "where";
            }
            $sql .= " " . $where . " USER_NAME = '".$uname."' ";
        }
        if (isset($oname) && !empty($oname)) {
            if ($where == "where") {
                $where = "and";
            } elseif ($where == "and") {
                $where = "and";
            } else {
                $where = "where";
            }
            $sql .= " " . $where . " OBJECT_NAME = '".$oname."' ";
        }
        if (isset($start_date) && isset($end_date) && !empty($start_date) && !empty($end_date)) {
            if ($where == "where") {
                $where = "and";
            } elseif ($where == "and") {
                $where = "and";
            } else {
                $where = "where";
            }
            $sql .= " " . $where . " DATE(`DATE`) between '".$start_date."'". " and '" .$end_date. "' ";
        }

        $sql .= " ORDER BY DATE ".$order." limit ".$perpage." offset ".$start." ";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
        $logs = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }
            $logs[] =$arr;
        }
        return $logs;
    }

    public function count_searchLog($oid, $oname, $uname, $start_date, $end_date)
    {
        $where = "";
        $sql = "select count(*) as num from logs ";
        if (isset($oid) && !empty($oid)) {
            $where = "where";
            $sql .= " " . $where . " OBJECT_ID = '".$oid."' ";
        }
        if (isset($uname) && !empty($uname)) {
            if ($where == "where") {
                $where = "and";
            } else {
                $where = "where";
            }
            $sql .= " " . $where . " USER_NAME = '".$uname."' ";
        }
        if (isset($oname) && !empty($oname)) {
            if ($where == "where") {
                $where = "and";
            } elseif ($where == "and") {
                $where = "and";
            } else {
                $where = "where";
            }
            $sql .= " " . $where . " OBJECT_NAME = '".$oname."' ";
        }
        if (isset($start_date) && isset($end_date) && !empty($start_date) && !empty($end_date)) {
            if ($where == "where") {
                $where = "and";
            } elseif ($where == "and") {
                $where = "and";
            } else {
                $where = "where";
            }
            $sql .= " " . $where . " DATE(`DATE`) between '".$start_date."'". " and '" .$end_date. "' ";
        }

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
        $r = mysqli_fetch_array($query);
        return $r['num'];
    }

    public function log($oid, $oname, $uid, $uname, $op_name, $op_details)
    {
        $op_details=json_encode($op_details);
        $sql = "insert into logs ( OBJECT_ID, OBJECT_NAME, USER_ID, USER_NAME, OPERATION_NAME, BEFORE_CHANGE, AFTER_CHANGE, DATE) values (".$oid.",'".$oname."', ".$uid.",'".$uname."', '".$op_name."','' , '".$op_details."', NOW())";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }

    public function compareAndLog($oid, $oname, $uid, $uname, $op_name, $before_op_details, $after_op_details)
    {
        // get intersect elements of arr1 between arr1 and aar2
        $arr1_intersected_elenents_with_arr2 = array_intersect_key($before_op_details, $after_op_details);
        $diff=array_diff($after_op_details, $arr1_intersected_elenents_with_arr2);
        //return var_dump(json_encode($arr1_intersected_elenents_with_arr2));
        $bef = mysqli_real_escape_string($this->db, json_encode($arr1_intersected_elenents_with_arr2, \JSON_UNESCAPED_UNICODE));
        $after_op_details = mysqli_real_escape_string($this->db, json_encode($after_op_details, \JSON_UNESCAPED_UNICODE));
        $diff = mysqli_real_escape_string($this->db, json_encode($diff, \JSON_UNESCAPED_UNICODE));
        
        //return print_r($bef);
        // log query
        $sql = "insert into logs ( OBJECT_ID, OBJECT_NAME, USER_ID, USER_NAME, OPERATION_NAME, BEFORE_OPERATION_DETAILS, AFTER_OPERATION_DETAILS, DIFF_OPERATION_DETAILS, DATE) values (".$oid.",'".$oname."', ".$uid.",'".$uname."', '".$op_name."', '".$bef."', '".$after_op_details."', '".$diff."', NOW() )";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }

    // LATEST SUCCEED
    public function compareAndLogV2($oid, $oname, $uid, $uname, $op_name, $before_op_details, $after_op_details)
    {
        $before_values = array_intersect_key($before_op_details, $after_op_details);
        $after_values = array_intersect_key($after_op_details, $before_op_details);
        $new = array_diff($after_op_details, $before_values);
        $new_diff=json_encode($new, JSON_UNESCAPED_UNICODE);
        $old_diff=json_encode(array_intersect_key($before_values, $new), JSON_UNESCAPED_UNICODE);

        // only log query in db if there is an updates
        if (!empty($new_diff)) {
            $sql = "insert into logs ( OBJECT_ID, OBJECT_NAME, USER_ID, USER_NAME, OPERATION_NAME, BEFORE_CHANGE, AFTER_CHANGE, DATE) values (".$oid.",'".$oname."', ".$uid.",'".$uname."', '".$op_name."', '".$old_diff."', '".$new_diff."', NOW() )";
            $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
            if ($query) {
                return mysqli_insert_id($this->db);
            } else {
                return false;
            }
        }
    }

    // can be run in each admin login operation
    public function deleteOldLog($log_period)
    {
        switch ($log_period) {
            case 1:
                $log_period = 31;
                break;
            case 3:
                $log_period = 91;
                break;
            case 6:
                $log_period = 181;
                break;
            case 12:
            $log_period = 366;
        }
        // delete from logs table records older than period in setting [1 month/ 3months / 6 months / 1 year]
        $sql = "delete from logs where DATE < NOW() - INTERVAL ".$log_period." DAY";
        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}
