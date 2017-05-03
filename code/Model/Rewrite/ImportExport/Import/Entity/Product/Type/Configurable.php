<?php

/**
 * This class overwrites an function with an general error message and
 * logs an error message with more detail
 */
class Danslo_ApiImport_Model_Rewrite_ImportExport_Import_Entity_Product_Type_Configurable
    extends Mage_ImportExport_Model_Import_Entity_Product_Type_Configurable
{

    /**
     * Validate particular attributes columns.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return bool
     */
    protected function _isParticularAttributesValid(array $rowData, $rowNum)
    {
        if (!empty($rowData['_super_attribute_code'])) {
            $superAttrCode = $rowData['_super_attribute_code'];
            if (!$this->_isAttributeSuper($superAttrCode)) { // check attribute superity
                $this->_entityModel->addRowError(self::ERROR_ATTRIBUTE_CODE_IS_NOT_SUPER . ': ' . $superAttrCode, $rowNum);
                return false;
            } elseif (isset($rowData['_super_attribute_option']) && strlen($rowData['_super_attribute_option'])) {
                $optionKey = strtolower($rowData['_super_attribute_option']);
                if (!isset($this->_superAttributes[$superAttrCode]['options'][$optionKey])) {
                    $this->_entityModel->addRowError(self::ERROR_INVALID_OPTION_VALUE, $rowNum);
                    return false;
                }
                // check price value
                if (!empty($rowData['_super_attribute_price_corr'])
                    && !$this->_isPriceCorr($rowData['_super_attribute_price_corr'])
                ) {
                    $this->_entityModel->addRowError(self::ERROR_INVALID_PRICE_CORRECTION, $rowNum);
                    return false;
                }
            }
        }
        return true;
    }
}
