<?php

class services
{

    var $db;

    function services($db)
    {
        $this->db = $db;
    }


    function get_services()
    {

        $query = mysql_query("select * from  services order by service_order ASC ") or die (mysql_error());

        $services = array();
        $i = 0;
        while ($row = mysql_fetch_array($query)) {
//	array('service_id'=>$row['service_id'],'service_name'=>$row['service_name'],'service_short'=>$row['service_short'],'sevices_description'=>$row['sevices_description'])
            $services[$i] = $row;
            $i++;
        }

        return $services;
    }


    function get_services_rate()
    {

        $query = mysql_query("select * from  services order by service_id ASC ") or die (mysql_error());

        $services = array();
        $i = 0;
        while ($row = mysql_fetch_array($query)) {
            $services[$i] = array('service_id' => $row['service_id'], 'service_name' => $row['service_name'], 'sevices_description' => $row['sevices_description']);
            $i++;
        }

        return $services;
    }


    function get_addtional_services()
    {
        $sql = "";
        $query = mysql_query("select * from vehicle_addtional_services") or die (mysql_error());

        $zone = array();
        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $zone[] = $arr;
        }
        return $zone;
    }


    function add_add_vec_service($name)
    {

        $query = mysql_query("insert into vehicle_addtional_services(name) values (" . $this->db->qstr($name) . ");") or die (mysql_error());

        if ($query) return true;
        else return false;

    }

    function edit_add_vec_service($name, $id)
    {

        $query = mysql_query("update vehicle_addtional_services set name = " . $this->db->qstr($name) . " where id = " . $this->db->qstr($id) . "") or die (mysql_error());

        if ($query) return true;
        else return false;

    }

    function get_add_vec_service($id)
    {
        $query = mysql_query("select * from  vehicle_addtional_services where id = " . $this->db->qstr($id) . "") or die (mysql_error());
        $row = mysql_fetch_object($query);
        return $row;
    }

    function delete_add_vec_services($id)
    {
        $query = mysql_query("delete from vehicle_addtional_services where id = " . $this->db->qstr($id) . "") or die (mysql_error());
        $q = mysql_query("delete from  vehicles_additional where add_service_id = " . $this->db->qstr($id) . "");

        if ($query) return true;
        else return false;
    }


    function get_addtional_services_edit($id)
    {
        $query = mysql_query("select v.id as id ,v.name as name,va.fees as fees from vehicle_addtional_services as v inner join vehicles_additional as va on (v.id = va.add_service_id ) where va.vechile_id = '" . $id . "'") or die (mysql_error());

        $zone = array();
        while ($row = mysql_fetch_array($query)) {

            $zone[$row['id']] = $row['fees'];


        }
        return $zone;


    }


}


?>