<?php
namespace MagentoVlogs\BannerSlider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Analytics Resource Model
 * Handles database operations for analytics table
 */
class Analytics extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        // Table name, Primary key
        $this->_init('magentovlogs_banners_slider_analytics', 'id');
    }
}