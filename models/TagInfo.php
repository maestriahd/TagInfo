<?php
/**
 * Tag Info
 *
 * @copyright BADAC, Banco de Archivos Digitales de Arte en Colombia. 
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 */

/**
 * The Tag Info page record class.
 *
 * @package Tag Info
 */
class TagInfo extends Omeka_Record_AbstractRecord implements Zend_Acl_Resource_Interface
{
    public $tag_id;
    public $text;
    
    protected function _validate()
    {        
        if (empty($this->title)) {
            $this->addError('text', __('The page must be given a title.'));
        }        
    }
}

