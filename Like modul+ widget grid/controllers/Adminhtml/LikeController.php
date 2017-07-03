<?php

class Magedoc_Like_Adminhtml_LikeController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('customer'))->_title($this->__('Likes'));
        $this->loadLayout();
        $this->_setActiveMenu('customer');
        $this->_addContent($this->getLayout()->createBlock('magedoclike/adminhtml_like_post'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('magedoclike/adminhtml_like_post_grid')->toHtml()
        );
    }
    public function exportAlexCsvAction()
    {
        $fileName = 'like_magedoc.csv';
        $grid = $this->getLayout()->createBlock('magedoclike/adminhtml_like_post_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }
    public function exportAlexExcelAction()
    {
        $fileName = 'like_magedoc.xml';
        $grid = $this->getLayout()->createBlock('magedoclike/adminhtml_like_post_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

}