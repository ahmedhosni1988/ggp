<?php

class services
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }


    public function get_services()
    {
        $query = mysqli_query($this->db, "select * from  services order by service_order ASC ") or die(mysqli_error($this->db));

        $services = array();
        $i = 0;
        while ($row = mysqli_fetch_array($query)) {
            //	array('service_id'=>$row['service_id'],'service_name'=>$row['service_name'],'service_short'=>$row['service_short'],'sevices_description'=>$row['sevices_description'])
            $services[$i] = $row;
            $i++;
        }

        return $services;
    }


    public function get_services_rate()
    {
        $query = mysqli_query($this->db, "select * from  services order by service_id ASC ") or die(mysqli_error($this->db));

        $services = array();
        $i = 0;
        while ($row = mysqli_fetch_array($query)) {
            $services[$i] = array('service_id' => $row['service_id'], 'service_name' => $row['service_name'], 'sevices_description' => $row['sevices_description']);
            $i++;
        }

        return $services;
    }


    public function get_addtional_services()
    {
        $sql = "";
        $query = mysqli_query($this->db, "select * from vehicle_addtional_services") or die(mysqli_error($this->db));

        $zone = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $zone[] = $arr;
        }
        return $zone;
    }


    public function add_add_vec_service($name)
    {
        $query = mysqli_query($this->db, "insert into vehicle_addtional_services(name) values (" . check_mysql_string($this->db,$name) . ");") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function edit_add_vec_service($name, $id)
    {
        $query = mysqli_query($this->db, "update vehicle_addtional_services set name = " . check_mysql_string($this->db,$name) . " where id = " . check_mysql_string($this->db,$id) . "") or die(mysqli_error($this->db));

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function get_add_vec_service($id)
    {
        $query = mysqli_query($this->db, "select * from  vehicle_addtional_services where id = " . check_mysql_string($this->db,$id) . "") or die(mysqli_error($this->db));
        $row = mysqli_fetch_object($query);
        return $row;
    }

    public function delete_add_vec_services($id)
    {
        $query = mysqli_query($this->db, "delete from vehicle_addtional_services where id = " . check_mysql_string($this->db,$id) . "") or die(mysqli_error($this->db));
        $q = mysqli_query($this->db, "delete from  vehicles_additional where add_service_id = " . check_mysql_string($this->db,$id) . "");

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


    public function get_addtional_services_edit($id)
    {
        $query = mysqli_query($this->db, "select v.id as id ,v.name as name,va.fees as fees from vehicle_addtional_services as v inner join vehicles_additional as va on (v.id = va.add_service_id ) where va.vechile_id = '" . $id . "'") or die(mysqli_error($this->db));

        $zone = array();
        while ($row = mysqli_fetch_array($query)) {
            $zone[$row['id']] = $row['fees'];
        }
        return $zone;
    }
}
