<?php

class messages
{


    var $db;

    function messages($db)
    {
        $this->db = $db;
    }


    function send_message($array, $thread_id)
    {
        $array['m_date'] = date('Y-m-d H:i:s');
        $array['thread_id'] = $thread_id;  // added by koko
        $sql = $this->db->make_insert("messages", $array);
        $query = mysql_query($sql);

        if ($query) return mysql_insert_id();
        else return false;

    }

// Edited by koko
    function get_inbox_messages($account_id, $user_id)
    {

        $query = mysql_query("select m1.* from messages m1  join (SELECT thread_id, MAX(m_id) m_id FROM messages where m_to = " . $this->db->qstr($user_id) . " and m_account_id = " . $this->db->qstr($account_id) . "  and  m_type = 'dis_replay' and thread_id != 0 GROUP BY thread_id) m2 on m1.m_id = m2.m_id AND m1.thread_id = m2.thread_id order by m1.m_id DESC ") or die (mysql_error());

        $messages = array();

        while ($row = mysql_fetch_assoc($query)) {

            foreach ($row as $key => $value) {

                $arr[$key] = $value;
            }

            $messages[] = $arr;
        }


        return $messages;


    }
// End Edit by koko

//Start koko
    function get_Prev_msg($thread_id)
    {

        $query = mysql_query("select * from messages where thread_id = '" . $thread_id . "'  order by m_id ASC  ") or die (mysql_error());

        if (mysql_num_rows($query) > 0) {

            $prevmessage = array();

            while ($row = mysql_fetch_assoc($query)) {
                foreach ($row as $key => $value) {
                    $arr[$key] = $value;
                }
                $prevmessage[] = $arr;
            }
            return $prevmessage;
        } else {
            return false;
        }
    }

    function get_message($id)
    {
        $query = mysql_query("select * from messages where m_id = $id") or die (mysql_error());
        if (mysql_num_rows($query) == 1) {
            $row = mysql_fetch_assoc($query);
            return $row;
        } else {
            return false;
        }
    }

    function add_new_msg_thread($user_id, $user_name, $account_id, $account_name)
    {
        $query = mysql_query("insert into messages_thread (mt_user_id,mt_user_name,mt_account_id,mt_account_name) VALUES ('" . $user_id . "','" . $user_name . "','" . $account_id . "','" . $account_name . "')") or die(mysql_error());

        if ($query) return mysql_insert_id();
        else return false;

    }
//End koko


}

?>