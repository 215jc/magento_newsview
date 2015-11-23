<?php
class JC_NewsView_Model_Resource_News
    extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        /**
         * Tell Magento the database name and primary key field to persist 
         * data to. Similar to the _construct() of our Model, Magento finds 
         * this data from config.xml by finding the <resourceModel/> node 
         * and locating children of <entities/>.
         * 
         * In this example:
         * - jc_newsview is the Model alias
         * - news is the entity referenced in config.xml
         * - entity_id is the name of the primary key column
         * 
         * As a result Magento will write data to the table 
         * 'jc_newsview_news' and any calls to 
         * $model->getId() will retrieve the data from the column 
         * named 'entity_id'.
         */
        $this->_init('jc_newsview/news', 'entity_id');
    }
}