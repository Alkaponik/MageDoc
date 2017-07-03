<?php
class Magedoc_Like_Block_Likeproduct
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{

    protected function _toHtml()
    {

        $widgetCollection = Mage::getModel('widget/widget_instance')->getCollection()
            ->addFieldToFilter('instance_type', ['eq'=>'magedoclike/likeproduct']);
        $widgetParams = unserialize($widgetCollection->getData()[0]['widget_parameters']);
        $this->_title = $widgetParams['page_title'];
        $this->_size = $widgetParams['page_size'];
        if(isset($widgetParams['page_options']) && !empty($widgetParams['page_options']))
        {
            $this->_options = $widgetParams['page_options'];
        }
        else
        {
            $this->_options = '0';
        }

        $CategoryId = Mage::getModel('magedoclike/options')->getCategoryId();

        $collection = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*');
        $collection->getSelect()->order('at_like_count.like_count DESC')->limit($this->_size,0);
        $collection->joinField('like_count', 'magedoc_product_like_aggregate', 'like_count', 'product_id = entity_id',
            "at_like_count.store_id = " . $collection->getStoreId(), 'inner');


        if($this->_options == 0)
        {
            if(!empty($CategoryId))
            {
                $category = Mage::getModel('catalog/category')->load($CategoryId);
                $collection->addCategoryFilter($category);
            }
        }
        else
        {
            if(!empty($CategoryId)) {
                $collection->joinField('category_id', 'catalog/category_product', 'category_id',
                    'product_id = entity_id', null, 'left');
                $multiselectCategory = array();

                foreach($this->_options as $key => $val)
                {
                    $multiselectCategory[] =  array('finset' => $val);
                }
                $collection->addAttributeToFilter('category_id', $multiselectCategory);
            }

        }
        $this->setLikeProducts($collection);
        return parent::_toHtml();
    }
}