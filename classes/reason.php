<?php

class reason
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }


    public function get_all_reason()
    {
        $sql = "select * from lookup_error ";

        $query = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));


        $category = array();
        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;
    }
}
