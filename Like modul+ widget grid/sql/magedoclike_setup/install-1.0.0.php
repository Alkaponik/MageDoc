<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$tableLike = $installer->getTable('magedoclike/table_like');
$tableLikeAgregate = $installer->getTable('magedoclike/table_like_agregate');

$installer->startSetup();
/**
 * Create table 'magedoclike/table_like'
 */
$table = $installer->getConnection()
    ->newTable($tableLike)
    ->addColumn('like_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true
    ))
    ->addColumn('product_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null, array(
        'nullable' => false,
    ))
    ->addColumn('customer_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null, array(
        'nullable' => false,
    ))
    ->addColumn('customer_ip',Varien_Db_Ddl_Table::TYPE_VARCHAR,null, array(
        'nullable' => false,
    ))
    ->addColumn('created_at',Varien_Db_Ddl_Table::TYPE_DATETIME,null, array(
        'nullable' => false,
    ));
$installer->getConnection()->createTable($table);

/**
 * Create table 'magedoclike/table_like_agregate'
 */
$table1 = $installer->getConnection()
    ->newTable($tableLikeAgregate)
    ->addColumn('id',Varien_Db_Ddl_Table::TYPE_INTEGER,null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true
    ))
    ->addColumn('product_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null, array(
        'nullable' => false,
    ))
    ->addColumn('store_id',Varien_Db_Ddl_Table::TYPE_INTEGER,null, array(
        'nullable' => false,
    ))
    ->addColumn('like_count',Varien_Db_Ddl_Table::TYPE_INTEGER,null, array(
        'nullable' => false,
    ))
    ->addIndex($installer->getIdxName('magedoclike/table_like_agregate', array('product_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('product_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE));

$installer->getConnection()->createTable($table1);

$installer->endSetup();




