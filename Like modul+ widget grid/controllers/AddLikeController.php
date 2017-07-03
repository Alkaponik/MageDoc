<?php
class Magedoc_Like_AddLikeController extends Mage_Core_Controller_Front_Action {

    public function likeResultAction()
    {
        $helper = Mage::helper('magedoclike');
        $customerIp = $helper->getClientIp();
        $today = date("Y-m-d H:i:s");
        $productId = $this->getRequest()->getPost('product_id');

        $customerId = Mage::getModel('magedoclike/like')->GetCustomerId();

        $searchLike = Mage::getModel('magedoclike/like')->searchLike($productId, $customerIp, $customerId, $today);
        if (empty($searchLike))
        {
            try{
                Mage::getModel('magedoclike/like')->AddLike($productId, $customerIp, $customerId, $today);
                $storeId = Mage::app()->getStore()->getStoreId();
                $searchLikeCount = Mage::getModel('magedoclike/likeagregate')->searchLikeCount($productId, $storeId);
                echo $searchLikeCount;
            }
            catch (Exception $e) {
                Mage::logException($e);
            }
        }
    }
}