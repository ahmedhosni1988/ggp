<?php

class messages
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }


    public function send_message($array, $thread_id)
    {
        $array['m_date'] = date('Y-m-d H:i:s');
        $array['thread_id'] = $thread_id;  // added by koko
        $sql = $this->db->make_insert("messages", $array);
        $query = mysqli_query($this->db, $sql);

        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }

    // Edited by koko
    public function get_inbox_messages($account_id, $user_id)
    {
        $query = mysqli_query($this->db, "select m1.* from messages m1  join (SELECT thread_id, MAX(m_id) m_id FROM messages where m_to = " . check_mysql_string($this->db,$user_id) . " and m_account_id = " . check_mysql_string($this->db,$account_id) . "  and  m_type = 'dis_replay' and thread_id != 0 GROUP BY thread_id) m2 on m1.m_id = m2.m_id AND m1.thread_id = m2.thread_id order by m1.m_id DESC ") or die(mysqli_error($this->db));

        $messages = array();

        while ($row = mysqli_fetch_assoc($query)) {
            foreach ($row as $key => $value) {
                $arr[$key] = $value;
            }

            $messages[] = $arr;
        }


        return $messages;
    }
    // End Edit by koko

    //Start koko
    public function get_Prev_msg($thread_id)
    {
        $query = mysqli_query($this->db, "select * from messages where thread_id = '" . $thread_id . "'  order by m_id ASC  ") or die(mysqli_error($this->db));

        if (mysqli_num_rows($query) > 0) {
            $prevmessage = array();

            while ($row = mysqli_fetch_assoc($query)) {
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

    public function get_message($id)
    {
        $query = mysqli_query($this->db, "select * from messages where m_id = $id") or die(mysqli_error($this->db));
        if (mysqli_num_rows($query) == 1) {
            $row = mysqli_fetch_assoc($query);
            return $row;
        } else {
            return false;
        }
    }

    public function add_new_msg_thread($user_id, $user_name, $account_id, $account_name)
    {
        $query = mysqli_query($this->db, "insert into messages_thread (mt_user_id,mt_user_name,mt_account_id,mt_account_name) VALUES ('" . $user_id . "','" . $user_name . "','" . $account_id . "','" . $account_name . "')") or die(mysqli_error($this->db));

        if ($query) {
            return mysqli_insert_id($this->db);
        } else {
            return false;
        }
    }
    //End koko
}
