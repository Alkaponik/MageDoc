<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11.04.2017
 * Time: 12:21
 */
class Magedoc_Like_Block_Adminhtml_Renderer_Store
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $store = explode(',',$row->getStoreId());
        $data="";
        if($row->getStoreId()!="" and $row->getStoreId()==0)
        {
            $allstore=Mage::app()->getStores();
            foreach($allstore as $astore)
            {
                $data.=$astore->getName().'<br />';
            }

        } else {
            $data="";
            $a=0;
            foreach ($store as $sto)
            {
                $data= $data.Mage::getModel('core/store')->load($sto[$a])->getName().'<br>';
                $a+1;
            }
        }

        return $data;
    }
}