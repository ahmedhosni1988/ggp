<?php


class inventory
{
    public $db;

    public function __construct($db)
    {
        $this->db = $db->get_conn();
    }

    public function get_inventory($id = "0")
    {
        if ($id == "0") {
            $query = mysqli_query($this->db, "select inventory_items.*,inventory_items.item_name,inventory_stock.quantity,inventory_stock.last_update 
            from inventory_stock 
            inner join inventory_items on (inventory_stock.item_id = inventory_items.id ) order by inventory_items.id ");
        }


        return build_array($query);
    }


    public function get_purchising_bill()
    {
        $query = mysqli_query($this->db, "select inventory_bill.*,CONCAT(suppliers.account_name, ' | ',suppliers.account_company) as account
            from inventory_bill
            inner join suppliers on (suppliers.account_id = inventory_bill.account_id )
            ");


        return build_array($query);
    }


    public function get_all_items()
    {
        $query = mysqli_query($this->db, "select inventory_items.id,inventory_items.item_name,inventory_items_color.color_name,inventory_items_company.company_name,package_type.package_name,CONCAT(inventory_items_size.item_width, ' * ',inventory_items_size.item_height) as size
            from inventory_items 
            inner join inventory_items_color on (inventory_items_color.id = inventory_items.item_color )
            inner join inventory_items_company on (inventory_items_company.id = inventory_items.item_company )
            inner join inventory_items_size on (inventory_items_size.id = inventory_items.item_size )
            inner join package_type on (package_type.package_id = inventory_items.item_thickness ) order by package_type.package_order  ");


        return build_array($query);
    }


    public function update_inventory($item_id, $quantity, $reason)
    {
        $query = mysqli_query($this->db, "select * from inventory_stock where item_id = '" . $item_id . "' ");

        if (mysqli_num_rows($query) == "1") {
            if ($reason == "1") {
                mysqli_query($this->db, "update inventory_stock set quantity = quantity + '" . $quantity . "' ,last_update = '" . date("Y-m-d H:i:s") . "' where item_id = '" . $item_id . "'   ");
            }
        } else {
            if ($reason == "1") {
                mysqli_query($this->db, "insert into inventory_stock (item_id,quantity,last_update) values ('" . $item_id . "','" . $quantity . "','" . date("Y-m-d H:i:s") . "') ; ");
            }
        }
    }


    public function get_inventory_stock($data)
    {
        $query = mysqli_query($this->db, "select 
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
                
                order by inventory_items.item_thickness ") or die(mysqli_error($this->db));

        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }

        return $result;
    }


    public function get_inventory_transaction($reason, $account_id)
    {
        $query = mysqli_query($this->db, "select inventory_action.*,inventory_items.item_name from inventory_action inner join inventory_items on (inventory_items.id = inventory_action.item_id) where inventory_action.reason = '" . $reason . "' and inventory_action.account_id = '" . $account_id . "' order by inventory_action.action_time DESC ");

        while ($row = mysqli_fetch_assoc($query)) {
            $result[] = $row;
        }

        return $result;
    }


    public function get_purchising_invoice($id)
    {
        $query = mysqli_query($this->db, "select 
        inventory_bill.*,
        inventory_bill.id as inventory_bill_id,
        inventory_action.id as inventory_action_id,
        inventory_action.*,
        CONCAT(suppliers.account_name, ' | ',suppliers.account_company) as account
        from inventory_bill 
        inner join suppliers on (suppliers.account_id = inventory_bill.account_id )
        inner join inventory_action on (inventory_action.bill_id = inventory_bill.id) 
        where inventory_bill.id = '$id' ") or die (mysqli_error($this->db));


        return build_array($query);
    }

    function delete_purchasing_invoice($id){

        //thsi funcction need to check if stock need modfication or not 
        $query = mysqli_query($this->db,"delete from inventory_action where bill_id = '$id' ");
        $query = mysqli_query($this->db,"delete from inventory_bill where id = '$id' ");

        return true;

    
    }
}
