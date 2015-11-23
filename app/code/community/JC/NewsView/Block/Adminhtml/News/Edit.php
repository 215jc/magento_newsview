<?php
class JC_NewsView_Block_Adminhtml_News_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'jc_newsview_adminhtml';
        $this->_controller = 'news';
        
        /**
         * The $_mode property tells Magento which folder to use to
         * locate the related form blocks to be displayed within this
         * form container. In our example this corresponds to 
         * NewsDirectory/Block/Adminhtml/News/Edit/.
         */
        $this->_mode = 'edit';
        
        $newOrEdit = $this->getRequest()->getParam('id')
            ? $this->__('Edit') 
            : $this->__('New');
        $this->_headerText =  $newOrEdit . ' ' . $this->__('News');
    }
}