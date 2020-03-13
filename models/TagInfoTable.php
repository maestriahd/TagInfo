<?php
/**
 * Tag Info
 *
 *
 */

/**
 * The Tag Info table class.
 *
 * @package TagInfo
 */
class SimplePagesPageTable extends Omeka_Db_Table
{

 public function applySearchFilters($select, $params)
    {
        $alias = $this->getTableAlias();
        $paramNames = array('tag_id');
                            
        foreach($paramNames as $paramName) {
            if (isset($params[$paramName])) {             
                $select->where($alias . '.' . $paramName . ' = ?', array($params[$paramName]));
            }            
        }
    }   
}