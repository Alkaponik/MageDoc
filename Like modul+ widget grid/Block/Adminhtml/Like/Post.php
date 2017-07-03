<?php
class Magedoc_Like_Block_Adminhtml_Like_Post extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'magedoclike';
        $this->_controller = 'adminhtml_like_post';
        $this->_headerText = Mage::helper('magedoclike')->__('Likes');
        parent::__construct();
        $this->_removeButton('add');
    }
}