<?php
require_once 'app/models/Core/Table.php';

class Model_Customergroup extends Model_Core_Table
{
    protected $_tablename = 'customer_groups';
    protected $_primarykey = 'customer_group_id';
}
