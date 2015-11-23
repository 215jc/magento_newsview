<?php
class JC_NewsView_Block_Adminhtml_News_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        // instantiate a new form to display our news for editing
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl(
                'jc_newsview_admin/news/edit', 
                array(
                    '_current' => true,
                    'continue' => 0,
                )
            ),
            'method' => 'post',
        ));
        $form->setUseContainer(true);
        $this->setForm($form);
        
        // define a new fieldset, we only need one for our simple entity
        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('News Item')
            )
        );
        
        $newsSingleton = Mage::getSingleton(
            'jc_newsview/news'
        );

        // Get the current news item;
        $news_item = Mage::registry('news_item');
        
        // add the fields we want to be editable
        $this->_addFieldsToFieldset($fieldset, array(
            'title' => array(
                'label' => $this->__('Title'),
                'input' => 'text',
                'required' => true,
                'value' => $news_item->getData('title')
            ),
            'summary' => array(
                'label' => $this->__('Summary'),
                'input' => 'textarea',
                'required' => true,
                'value' => $news_item->getData('summary')
            ),
            'content' => array(
                'label' => $this->__('Content'),
                'input' => 'textarea',
                'required' => true,
                'value' => $news_item->getData('content')
            ),
            
            /**
             * Note: we have not included created_at or updated_at,
             * we will handle those fields ourself in the Model before save.
             */
        ));

        return $this;
    }
    
    /**
     * This method makes life a little easier for us by pre-populating 
     * fields with $_POST data where applicable and wraps our post data in 
     * 'newsData' so we can easily separate all relevant information in
     * the controller. You can of course omit this method entirely and call
     * the $fieldset->addField() method directly.
     */
    protected function _addFieldsToFieldset(
        Varien_Data_Form_Element_Fieldset $fieldset, $fields)
    {
        $requestData = new Varien_Object($this->getRequest()
            ->getPost('newsData'));
        
        foreach ($fields as $name => $_data) {
            if ($requestValue = $requestData->getData($name)) {
                $_data['value'] = $requestValue;
            }
            
            // wrap all fields with newsData group
            $_data['name'] = "newsData[$name]";
            
            // generally label and title always the same
            $_data['title'] = $_data['label'];
            
            // finally call vanilla functionality to add field
            $fieldset->addField($name, $_data['input'], $_data);
        }
        
        return $this;
    }
}