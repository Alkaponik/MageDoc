<?php

class Magedoc_Like_Model_Like extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        parent::_construct();
        $this->_init('magedoclike/like');
    }

    /**
     * Select data like Product
     *
     * @param int $productId
     * @param string $customerIp
     * @param string $customerId
     * @param datetime('Y-m-d H:i:s') $today
     * @return array()
     */
    public function searchLike($productId, $customerIp, $customerId, $today)
    {
        $helper = Mage::helper('magedoclike');
        $startDay = $helper->StartDate($today);

        $resource = Mage::getSingleton('core/resource');
        $read = $resource->getConnection('core_read');
        $tableLike = $resource->getTableName('magedoclike/table_like');

        $select = $read->select()
            ->from(['tbl' => $tableLike], ['product_id', 'customer_ip','created_at'])
            ->where('product_id = ?', $productId)
            ->where('customer_ip = ?', $customerIp)
            ->where('customer_id = ?', $customerId)
            ->limit(1);
            if($customerId == 0) {
                $select = $select
                ->where('created_at >= ?', $startDay)
                ->where('created_at <= ?', $today);
            }

        $results = $read->fetchAll($select);
        return $results;
    }

    /**
     * Insert data Product
     *
     * @param int $productId
     * @param string $customerIp
     * @param int $customerId
     * @param datetime('Y-m-d H:i:s') $today
     */
    public function AddLike($productId, $customerIp, $customerId, $today)
    {
        $resource = Mage::getSingleton('core/resource');
        $write = $resource->getConnection('core_write');
        $tableLike = $resource->getTableName('magedoclike/table_like');
        $rows = array(array('product_id' => $productId, 'customer_ip' => $customerIp, 'customer_id' => $customerId,
            'created_at' => $today));
        $write->insertMultiple($tableLike, $rows);
        $tableLikeAgregate = $resource->getTableName('magedoclike/table_like_agregate');
        $storeId = Mage::app()->getStore()->getStoreId();
        $likeCounts = Mage::getModel('magedoclike/likeagregate')->searchLikeCount($productId,$storeId);

        //Insert Update On Duplicate:

        $data = array();
        $data[] = array(
            'like_count' =>  $likeCounts + 1,
            'product_id' => $productId,
            'store_id' => $storeId ,
        );
        $write->insertOnDuplicate(
            $tableLikeAgregate,
            $data,
            array('like_count') // this is the fields that will be updated in case of duplication
        );
    }
    /**
     * Get CustomerId user
     *
     * @return int
     */
    public function GetCustomerId()
    {
        if(Mage::getSingleton('customer/session')->isLoggedIn())
        {
            $customerData = Mage::getSingleton('customer/session')->getCustomer();
            return $customerData->getId();
        }
        else
        {
            return 0;
        }
    }

}