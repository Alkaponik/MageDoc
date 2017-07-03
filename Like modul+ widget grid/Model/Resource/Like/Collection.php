<?php

class Magedoc_Like_Model_Resource_Like_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Resource initialization
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('magedoclike/like');
    }
    public function addStoreFilter($store, $withAdmin = true){

        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        if (!is_array($store)) {
            $store = array($store);
        }

        $this->addFilter('likeagregate.store_id', array('in' => $store));

        return $this;
    }
}