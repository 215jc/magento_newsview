<?php
class JC_NewsView_Adminhtml_NewsController
    extends Mage_Adminhtml_Controller_Action
{
    /**
     * Instantiate our grid container block and add to the page content.
     * When accessing this admin index page we will see a grid of all
     * newss currently available in our Magento instance, along with
     * a button to add a new one if we wish.
     */
    public function indexAction()
    {
        // instantiate the grid container
        $newsBlock = $this->getLayout()
            ->createBlock('jc_newsview_adminhtml/news');
        
        // add the grid container as the only item on this page
        $this->loadLayout()
            ->_addContent($newsBlock)
            ->renderLayout();
    }
    
    /**
     * This action handles both viewing and editing of existing newss.
     */
    public function editAction()
    {
        /**
         * retrieving existing news data if an ID was specified,
         * if not we will have an empty News entity ready to be populated.
         */
        $news = Mage::getModel('jc_newsview/news');
        if ($newsId = $this->getRequest()->getParam('id', false)) {
            $news->load($newsId);

            if ($news->getId() < 1) {
                $this->_getSession()->addError(
                    $this->__('This news no longer exists.')
                );
                return $this->_redirect(
                    'jc_newsview_admin/news/index'
                );
            }
        }
        
        // process $_POST data if the form was submitted
        if ($postData = $this->getRequest()->getPost('newsData')) {
            try {
                $news->addData($postData);
                $news->save();
                
                $this->_getSession()->addSuccess(
                    $this->__('The news has been saved.')
                );
                
                // redirect to remove $_POST data from the request
                return $this->_redirect(
                    'jc_newsview_admin/news/edit', 
                    array('id' => $news->getId())
                );
            } catch (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }
            
            /**
             * if we get to here then something went wrong. Continue to
             * render the page as before, the difference being this time 
             * the submitted $_POST data is available.
             */
        }
        
        // make the current news object available to blocks
        Mage::register('news_item', $news);
        
        // instantiate the form container
        $newsEditBlock = $this->getLayout()->createBlock(
            'jc_newsview_adminhtml/news_edit'
        );
        
        // add the form container as the only item on this page
        $this->loadLayout()
            ->_addContent($newsEditBlock)
            ->renderLayout();
    }
    
    public function deleteAction()
    {
        $news = Mage::getModel('jc_newsview/news');

        if ($newsId = $this->getRequest()->getParam('id', false)) {
            $news->load($newsId);
        }
        
        if ($news->getId() < 1) {
            $this->_getSession()->addError(
                $this->__('This news no longer exists.')
            );
            return $this->_redirect(
                'jc_newsview_admin/news/index'
            );
        }
        
        try {
            $news->delete();
            
            $this->_getSession()->addSuccess(
                $this->__('The news has been deleted.')
            );
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }

        return $this->_redirect(
            'jc_newsview_admin/news/index'
        );
    }
    
    /**
     * Thanks to Ben for pointing out this method was missing. Without 
     * this method the ACL rules configured in adminhtml.xml are ignored.
     */
    protected function _isAllowed()
    {
        /**
         * we include this switch to demonstrate that you can add action 
         * level restrictions in your ACL rules. The isAllowed() method will
         * use the ACL rule we have configured in our adminhtml.xml file:
         * - acl 
         * - - resources
         * - - - admin
         * - - - - children
         * - - - - - jc_newsview
         * - - - - - - children
         * - - - - - - - news
         * 
         * eg. you could add more rules inside news for edit and delete.
         */
        $actionName = $this->getRequest()->getActionName();
        switch ($actionName) {
            case 'index':
            case 'edit':
            case 'delete':
                // intentionally no break
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession
                    ->isAllowed('jc_newsview/news');
                break;
        }
        
        return $isAllowed;
    }
}