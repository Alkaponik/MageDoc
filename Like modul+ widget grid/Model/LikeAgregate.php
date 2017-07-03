<?php
class Magedoc_Like_Model_LikeAgregate extends Mage_Core_Model_Abstract {

    public function _construct()
    {
        parent::_construct();
        $this->_init('magedoclike/likeagregate');

    }

    /**
     * Select like count for Product
     * @param int $storeId
     * @param int $productId
     * @return int
     */
    public function searchLikeCount($productId, $storeId)
    {
        $model= Mage::getModel('magedoclike/likeagregate')->load(array('product_id'=> $productId, 'store_id'=> $storeId));
        $result = $model->getlike_count();
        return $result;
    }

}