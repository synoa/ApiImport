<?php
/*
 * Copyright 2011 Daniel Sloof
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

class Danslo_ApiImport_Helper_Data
    extends Mage_Core_Helper_Abstract {

      public function getAllTranslationsForAnAttributeOption($attributeId, $optionId, $adminLabel) {
        $result = array();

        $storeViews = Mage::app()->getStores();

        $allOptionsInAllStoreViews = array();
        foreach ($storeViews as $storeView) {
          $allOptionsInAllStoreViews[$storeView->getId()] = Mage::getResourceModel('eav/entity_attribute_option_collection')
            ->setAttributeFilter($attributeId)
            ->setStoreFilter($storeView->getId())
            ->load()
            ->toOptionArray()
          ;
        }

        foreach ($allOptionsInAllStoreViews as $storeViewId=>$storeViewOptions) {
          foreach ($storeViewOptions as $storeViewOption) {
            if ($storeViewOption['value'] == $optionId) {
              if ($storeViewOption['label'] != $adminLabel) {
                $result[$storeViewId] = $storeViewOption['label'];
              }
            }
          }
        }

        return $result;
      }
}
