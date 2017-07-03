<?php

class Magedoc_Like_Model_Observer
{

    public function catalogProductCollectionLoadBefore($observer) {
        $collection = $observer['collection'];

        $select = $collection->getSelect()->joinLeft(array('pc' => 'magedoc_product_like_aggregate'),
            'pc.product_id = e.entity_id AND pc.store_id = '. $collection->getStoreId(),
            'pc.like_count');

        return $select;

    }
}