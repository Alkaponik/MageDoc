<?php
class Magedoc_Like_Block_Adminhtml_Like_Post_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('like_grid');
        $this->setDefaultSort('product_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('magedoclike');
        $this->addColumn('product_id', array(
            'header' => $helper->__('Product Id'),
            'index'  => 'product_id'
        ));
        $this->addColumn('product_name', array(
            'header' => $helper->__('Name Product'),
            'filter_condition_callback' => array($this, '_nameProduct'),
            'type'   => 'text',
            'index'  => 'product_name'
        ));
        $this->addColumn('first_name', array(
            'header' => $helper->__('Name Klient'),
            'renderer' => 'Magedoc_Like_Block_Adminhtml_Renderer_Name',
            'filter_condition_callback' => array($this, '_nameFilter'),
        ));
        $this->addColumn('customer_ip', array(
            'header' => $helper->__('IP Adress'),
            'type'   => 'text',
            'index'  => 'customer_ip'
        ));
        $this->addColumn('created_at', array(
            'header'       => $helper->__('Data Like'),
            'index'        => 'created_at',
            'type' => 'datetime'
        ));
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store', array(
                'header' => 'Choose Store View:',
                'index' => 'store_id',
                'type' => 'store',
                'store_all' => true,
                'store_view' => true,
                'sortable' => true,
                'display_deleted' => false,
                'renderer' => 'Magedoc_Like_Block_Adminhtml_Renderer_Store',
                'filter_condition_callback' => array($this,
                    '_filterStoreCondition'),
            ));
        }

        $this->addExportType('*/*/exportLikeCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportLikeExcel', $helper->__('Excel XML'));
        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    protected function _prepareCollection()
    {
        $productCollection = Mage::getModel('magedoclike/like')->getCollection()
            ->addFieldToSelect('created_at')
            ->addFieldToSelect('customer_ip')
            ->addFieldToSelect('customer_id')
            ->addFieldToSelect('product_id');
        $firstname  = Mage::getResourceModel('customer/customer')->getAttribute('firstname');
        $lastname = Mage::getResourceModel('customer/customer')->getAttribute('lastname');
        $product =  Mage::getResourceModel('catalog/product')->getAttribute('name');

        $productCollection->getSelect()
            ->join(
                array('product' => $product->getBackend()->getTable()),'product.entity_id = product_id AND
                product.attribute_id = '.(int) $product->getAttributeId() . '', 'product.value as product_name'
            )
            ->joinInner(
                array('likeagregate' => $productCollection->getTable('magedoclike/table_like_agregate')),
                'likeagregate.product_id = product.entity_id', array('likeagregate.store_id')
            )
            ->joinLeft(
                array('customer' => $firstname->getBackend()->getTable()), 'customer.entity_id = customer_id AND
                 customer.attribute_id = '.(int) $firstname->getAttributeId() . '', "IFNULL(customer.value,'Guest') AS first_name"
            )
            ->joinLeft(
                array('custom' => $lastname->getBackend()->getTable()), 'custom.entity_id = customer_id AND
                custom.attribute_id = '.(int) $lastname->getAttributeId() . '', 'custom.value AS last_name'
            );

        $this->setCollection($productCollection);

        parent::_prepareCollection();
        return $this;
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }

    protected function _nameFilter($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue())
        {
            return $collection;
        }
        $values = explode(' ', $value);
        for($i=0; $i<count($values); $i++)
        {
            $collection->getSelect()
                ->where( "customer.value like ? OR custom.value like ?", "%{$values[$i]}%");
        }
        return $collection;
    }

    protected function _nameProduct($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue())
        {
            return $collection;
        }
        $values = explode(' ', $value);
        for($i=0; $i<count($values); $i++)
        {
            $collection->getSelect()
                ->where( "product.value like ?", "%{$values[$i]}%");
        }
        return $collection;
    }

}
