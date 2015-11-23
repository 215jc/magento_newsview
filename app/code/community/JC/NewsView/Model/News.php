<?php
class JC_NewsView_Model_News
    extends Mage_Core_Model_Abstract
{
    const VISIBILITY_HIDDEN = '0';
    const VISIBILITY_DIRECTORY = '1';
    
    protected function _construct()
    {
        /**
         * This tells Magento where the related Resource Model can be found.
         * 
         * For a Resource Model, Magento will use the standard Model alias,
         * in this case 'jc_newsview' and look in 
         * config.xml for a child node <resourceModel/>. This will be the
         * location Magento will look for a Model when 
         * Mage::getResourceModel() is called. In our case:
         * JC_NewsView_Model_Resource
         */
        $this->_init('jc_newsview/news');
    }
    
    protected function _beforeSave()
    {
        parent::_beforeSave();
        
        /**
         * Perform some actions just before News is saved.
         */
        $this->_updateTimestamps();
        
        return $this;
    }
    
    protected function _updateTimestamps()
    {
        $timestamp = now();
        
        /**
         * Set the last updated timestamp.
         */
        $this->setUpdatedAt($timestamp);
        
        /**
         * If we have a news new object, set the created timestamp.
         */
        if ($this->isObjectNew()) {
            $this->setCreatedAt($timestamp);
        }
        
        return $this;
    }
    
}