<?php

/*
 * Copyright 2013 Alexander Buch
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class Danslo_ApiImport_Model_Import_Api_V2 extends Danslo_ApiImport_Model_Import_Api
{

    /**
     * (non-PHPdoc)
     * @see Danslo_ApiImport_Model_Import_Api::importEntities()
     */
    public function importEntities($entities, $entityType = null, $behavior = null)
    {
        if (property_exists($entities[0], 'complexObjectArray')) {
            $entities = $this->convertToArray($entities);
        }
        $entities = $this->_prepareEntities($entities);
        return parent::importEntities($entities, $entityType, $behavior);
    }

    protected function convertToArray($entities) {
      $result = array();
      foreach ($entities as $item) {
        $result[] = $item->complexObjectArray;
      }
      return $result;
    }

    /**
     * Prepare incoming entities encoded as complexType apiImportImportEntitiesArray
     * for passthru to API V1 as associative array
     *
     * @param array $entities
     * @return void
     */
    protected function _prepareEntities(Array $entities)
    {
        $return = array();
        foreach ($entities as $i => &$entity) {
            $return[$i] = array();
            foreach ($entity as $j => &$object) {
                if (is_numeric($j)) {
                    $value = $object->value;
                    // Nullify empty values
                    /*
                    Code before was:

                    if (!trim($value)) {

                    This is not working if we provide a value like (int) 0

                    This will be nullified but it is a valid value for tax class e.g.
                     */
                    if (strlen(trim($value)) == 0) {
                        $value = NULL;
                    }
                    $return[$i][$object->key] = $value;
                }
                unset($object);
            }
            unset($entity);
        }
        return $return;
    }

}
