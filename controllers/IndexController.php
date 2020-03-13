<?php
/**
 * Tag Info
 * 
 * @copyright Copyright 2019 BADAC
 * @license http://opensource.org/licenses/MIT MIT
 */

/**
 * The Tag Info index controller class.
 * 
 * @package Omeka\Plugin\TagInfo
 */
class TagInfo_IndexController extends Omeka_Controller_AbstractActionController
{

    protected function _getForm($record)
    {
    
        $formOptions = array('type' => 'tag_infos');
        if($record && $record->exists()) {
            $formOptions['record'] = $record;
        }
    
        $form = new Omeka_Form_Admin($formOptions);

        $form->addElementToEditGroup(
            'textarea','description',
            array('id' => 'tag-info-text',
                'cols'  => 50,
                'rows'  => 25,
                'value' => 'hello',
                'label' => __('Text'),
                'description' => __(
                    'Add a descriptive text for this tag.'
                )
            )
        );
    
        // build the form elements
    
        return $form;
    }

    public function indexAction()
    {
        $this->view->tags = get_records('Tag', array(),0);
    }

    protected function _getTagInfo($element_id) {
        return get_db()
            ->getTable('tag_info')
            //->find($element_id);
            ->find(array('tag_id'=>$element_id), 1);
    }

    public function editAction()
    {
        $tag_id = $this->_getParam('tag_id');
        $tag = get_record_by_id('Tag', $tag_id);
        $this->view->tag = $tag;
        $tag_info = $this->_getTagInfo($tag_id);
        $this->view->tag_info = $tag_info;
        $form = $this->_getForm($tag_info);
        $this->view->form = $form;
        //$this->view->element = $this->_getElement($tag_id);
        //$this->view->element_type = $this->_getElementType($tag_id);
        //$this->view->element_types_info_options = $this->_getElementTypesInfoOptions();
        //return;
        $this->_processPageForm($tag_info, $form, 'add');

    }

    public function addAction()
    {
        // Create a new page.
        $tag_info = new TagInfo;
        
        // Set the created by user ID.
        $tag_info->created_by_user_id = current_user()->id;
        $tag_info->template = '';
        $tag_info->order = 0;
        $form = $this->_getForm($tag_info);
        $this->view->form = $form;
        $this->_processPageForm($tag_info, $form, 'add');
    }

    private function _processPageForm($tag_info, $form, $action)
    {
        // Set the page object to the view.
        $this->view->tag_info = $tag_info;
        $this->_helper->_flashMessenger(__('Got it'));

        if ($this->getRequest()->isPost()) {
            if (!$form->isValid($_POST)) {
                $this->_helper->_flashMessenger(__('There was an error on the form. Please try again.'), 'error');
                return;
            }

            try{
                $tag_info->setPostData($_POST);
                if ($tag_info->save()) {
                    if ('add' == $action) {
                        $this->_helper->flashMessenger(__('The tag info  has been added.'), 'success');
                    } else if ('edit' == $action) {
                        $this->_helper->flashMessenger(__('The page has been edited.'), 'success');
                    }
                    //$this->_helper->redirector('browse');
                    return;
                }
            }catch (Omeka_Validate_Exception $e) {
                $this->_helper->flashMessenger($e);
            }

        }else{
            $this->_helper->_flashMessenger(__('No Post'));
        }
    }

}
