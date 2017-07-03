<?php

class Magedoc_Like_Model_Resource_LikeAgregate_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    /**
     * Resource initialization
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('magedoclike/likeagregate');
    }
}