<?php

class Magedoc_Like_Model_Resource_LikeAgregate extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     * Initialize resource model
     *
     */
    public function _construct()
    {
        $this->_init('magedoclike/table_like_agregate', 'id');
    }

    protected function _getLoadSelect($field, $value, $object)
    {

        if (is_array($value)) {
            $select = $this->_getReadAdapter()->select()
                ->from($this->getMainTable());
            foreach ($value as $key => $val) {
                $field = $this->_getReadAdapter()->quoteIdentifier(sprintf('%s.%s', $this->getMainTable(), $key));
                $select->where($field . '=?', $val);
            }

            return $select;
        }
        else{
            parent::_getLoadSelect($field, $value, $object);
        }
    }

}