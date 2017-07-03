<?php

class Magedoc_Like_Block_Adminhtml_Renderer_Name extends  Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return $row->getFirstName().' '.$row->getLastName();
    }
}