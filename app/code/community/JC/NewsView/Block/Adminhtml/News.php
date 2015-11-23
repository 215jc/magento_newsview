<?php
class JC_NewsView_Block_Adminhtml_News
    extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();
        
        /**
         * The $_blockGroup property tells Magento which alias to use to
         * locate the blocks to be displayed within this grid container.
         * In our example this corresponds to NewsDirectory/Block/Adminhtml.
         */
        $this->_blockGroup = 'jc_newsview_adminhtml';
        
        /**
         * $_controller is a bit of a confusing name for this property. This 
         * value in fact refers to the folder containing our Grid.php and 
         * Edit.php. In our example, NewsDirectory/Block/Adminhtml/News, 
         * so we use 'news'.
         */
        $this->_controller = 'news';
        
        /**
         * The title of the page in the admin panel.
         */
        $this->_headerText = Mage::helper('jc_newsview')
            ->__('News Directory');
    }
    
    public function getCreateUrl()
    {
        /**
         * When the Add button is clicked, this is where the user should
         * be redirected to. In our example, the method editAction of 
         * NewsController.php in NewsDirectory module.
         */
        return $this->getUrl(
            'jc_newsview_admin/news/edit'
        );
    }
}