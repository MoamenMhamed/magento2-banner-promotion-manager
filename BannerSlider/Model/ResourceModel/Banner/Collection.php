<?php
namespace MagentoVlogs\BannerSlider\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        // Connect Model to ResourceModel
        $this->_init('MagentoVlogs\BannerSlider\Model\Banner', 'MagentoVlogs\BannerSlider\Model\ResourceModel\Banner');
    }
}

