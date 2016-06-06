<?php
/**
 *                  ___________       __            __
 *                  \__    ___/____ _/  |_ _____   |  |
 *                    |    |  /  _ \\   __\\__  \  |  |
 *                    |    | |  |_| ||  |   / __ \_|  |__
 *                    |____|  \____/ |__|  (____  /|____/
 *                                              \/
 *          ___          __                                   __
 *         |   |  ____ _/  |_   ____ _______   ____    ____ _/  |_
 *         |   | /    \\   __\_/ __ \\_  __ \ /    \ _/ __ \\   __\
 *         |   ||   |  \|  |  \  ___/ |  | \/|   |  \\  ___/ |  |
 *         |___||___|  /|__|   \_____>|__|   |___|  / \_____>|__|
 *                  \/                           \/
 *                  ________
 *                 /  _____/_______   ____   __ __ ______
 *                /   \  ___\_  __ \ /  _ \ |  |  \\____ \
 *                \    \_\  \|  | \/|  |_| ||  |  /|  |_| |
 *                 \______  /|__|    \____/ |____/ |   __/
 *                        \/                       |__|
 *
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future. If you wish to customize this module for your
 * needs please contact servicedesk@totalinternetgroup.nl for more information.
 *
 * @copyright   Copyright (c) 2016 Total Internet Group B.V. (http://www.totalinternetgroup.nl)
 */
class Tiny_CompressImages_Model_Observer
{
    /**
     * @var null|Tiny_CompressImages_Helper_Tinify
     */
    protected $_tinifyHelper = null;

    /**
     * The image cache is flushed, so all images are deleted. Therefore delete all models.
     *
     * @return $this
     */
    public function imageCacheFlush()
    {
        Mage::getModel('tig_tinypng/image')->deleteAll();

        return $this;
    }

    /**
     * Compress product images
     *
     * @param $observer
     *
     * @return $this
     */
    public function catalogProductImageSaveAfter($observer)
    {
        if ($this->_tinifyHelper === null) {
            $this->_tinifyHelper = Mage::helper('tig_tinypng/tinify');
        }

        $storeId = Mage::app()->getStore()->getStoreId();
        $this->_tinifyHelper->setProductImage($observer->getObject(), $storeId)->compress();

        return $this;
    }
}
