<?php

class Danslo_ApiImport_Model_Image extends Varien_Image
{
    /**
     * Destruct
     */
    public function __destruct()
    {
        $adapter = $this->_getAdapter();

        if ($adapter instanceof Varien_Image_Adapter_Gd2) {
            if (method_exists($adapter, 'destruct')) {
                $adapter->destruct();
            }
        }
    }
}

