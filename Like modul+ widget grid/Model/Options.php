<?php
class Magedoc_Like_Model_Options {
    /**
     * Provide available options as a value/label array
     *
     * @return array
     */
    public function toOptionArray() {

        $collection = Mage::getResourceModel('catalog/category_collection');

        $collection->addAttributeToSelect('name')
            ->addFieldToFilter('path', array('neq' => '1'))
            ->addFieldToFilter('is_active', array('eq'=>'1'))
            ->load();

        $options = array();

        foreach ($collection as $category) {
            $depth = count(explode('/', $category->getPath())) - 2;
            $indent = str_repeat('-', max($depth * 2, 0));
            $options[] = array(
                'value' => $category->getId(),
                'label' => $indent . $category->getName()
            );
        }

        return $options;
    }
    public function getCategoryId()
    {
        if ($category = Mage::registry('current_category')) {
            return $category->getId();
        }
        return false;
    }



}