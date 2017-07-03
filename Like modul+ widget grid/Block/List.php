<?php
class Magedoc_Like_Block_List extends Mage_Core_Block_Template {

    protected function getCountLike()
    {
        $params = $this->getRequest()->getParams();
        $storeId = Mage::app()->getStore()->getStoreId();
        return Mage::getModel('magedoclike/likeagregate')->searchLikeCount($params['id'],$storeId);
    }

}