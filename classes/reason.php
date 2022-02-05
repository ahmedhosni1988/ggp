<?php

class reason
{
    public $db;

    public function reason($db)
    {
        $this->db = $db;
    }


    public function get_all_reason()
    {
        $sql = "select * from lookup_error ";

        $query = mysql_query($sql) or die(mysql_error());


        $category = array();
        while ($row = mysql_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $category[] = $arr;
        }


        return $category;
    }
}

?>