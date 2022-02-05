<?php


class inventory
{

    var $db;

    function inventory($db)
    {
        $this->db = $db;
    }


    function get_inventory($id = "0")
    {

        if ($id == "0") {
            $query = mysql_query("select inventory_items.*,inventory_items.item_name,inventory_stock.quantity,inventory_stock.last_update 
            from inventory_stock 
            inner join inventory_items on (inventory_stock.item_id = inventory_items.id ) order by inventory_items.id ");

        }


        return $this->db->build_array($query);
    }


    function get_purchising_bill()
    {

        $query = mysql_query("select inventory_bill.*,CONCAT(suppliers.account_name, ' | ',suppliers.account_company) as account
            from inventory_bill
            inner join suppliers on (suppliers.account_id = inventory_bill.account_id )
            ");


        return $this->db->build_array($query);
    }


    function get_all_items()
    {

        $query = mysql_query("select inventory_items.id,inventory_items.item_name,inventory_items_color.color_name,inventory_items_company.company_name,package_type.package_name,CONCAT(inventory_items_size.item_width, ' * ',inventory_items_size.item_height) as size
            from inventory_items 
            inner join inventory_items_color on (inventory_items_color.id = inventory_items.item_color )
            inner join inventory_items_company on (inventory_items_company.id = inventory_items.item_company )
            inner join inventory_items_size on (inventory_items_size.id = inventory_items.item_size )
            inner join package_type on (package_type.package_id = inventory_items.item_thickness ) order by package_type.package_order  ");


        return $this->db->build_array($query);
    }


    function update_inventory($item_id, $quantity, $reason)
    {

        $query = mysql_query("select * from inventory_stock where item_id = '" . $item_id . "' ");

        if (mysql_num_rows($query) == "1") {

            if ($reason == "1") mysql_query("update inventory_stock set quantity = quantity + '" . $quantity . "' ,last_update = '" . date("Y-m-d H:i:s") . "' where item_id = '" . $item_id . "'   ");

        } else {
            if ($reason == "1") mysql_query("insert into inventory_stock (item_id,quantity,last_update) values ('" . $item_id . "','" . $quantity . "','" . date("Y-m-d H:i:s") . "') ; ");
        }
    }


    function get_inventory_stock($data)
    {

        $query = mysql_query("select 
                package_type.package_short,
                inventory_items.item_name,
                inventory_items_size.item_width,
                inventory_items_size.item_height,
                inventory_stock.quantity,
                ((inventory_items_size.item_width * inventory_items_size.item_height * inventory_stock.quantity)/10000) as 'Total',
                inventory_stock.last_update
                from inventory_stock 
                inner join inventory_items on (inventory_stock.item_id = inventory_items.id)
                inner join inventory_items_color on (inventory_items_color.id = inventory_items.item_color )
                inner join inventory_items_company on (inventory_items_company.id = inventory_items.item_company )
                inner join inventory_items_size on (inventory_items_size.id = inventory_items.item_size )
                inner join package_type on (package_type.package_id = inventory_items.item_thickness )
                
                order by inventory_items.item_thickness ") or die (mysql_error());

        while ($row = mysql_fetch_assoc($query)) {

            $result[] = $row;
        }

        return $result;


    }


    function get_inventory_transaction($reason, $account_id)
    {

        $query = mysql_query("select inventory_action.*,inventory_items.item_name from inventory_action inner join inventory_items on (inventory_items.id = inventory_action.item_id) where inventory_action.reason = '" . $reason . "' and inventory_action.account_id = '" . $account_id . "' order by inventory_action.action_time DESC ");

        while ($row = mysql_fetch_assoc($query)) {
            $result[] = $row;
        }

        return $result;
    }
}

?>