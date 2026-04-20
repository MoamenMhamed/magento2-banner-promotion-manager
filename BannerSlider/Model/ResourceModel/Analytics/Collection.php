<?php
namespace MagentoVlogs\BannerSlider\Model\ResourceModel\Analytics;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Analytics Collection
 * Handles fetching multiple analytics records
 */
class Collection extends AbstractCollection
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
        $this->_init(
            \MagentoVlogs\BannerSlider\Model\Analytics::class,
            \MagentoVlogs\BannerSlider\Model\ResourceModel\Analytics::class
        );
    }

    /**
     * Get analytics events by banner ID
     *
     * @param int $bannerId
     * @return $this
     */
    public function addBannerFilter($bannerId)
    {
        $this->addFieldToFilter('banner_id', $bannerId);
        return $this;
    }

    /**
     * Get analytics events by event type
     *
     * @param string $eventType
     * @return $this
     */
    public function addEventTypeFilter($eventType)
    {
        $this->addFieldToFilter('event_type', $eventType);
        return $this;
    }

    /**
     * Get analytics events by date range
     *
     * @param string $from Date in format Y-m-d
     * @param string $to Date in format Y-m-d
     * @return $this
     */
    public function addDateRangeFilter($from, $to)
    {
        $this->addFieldToFilter('created_at', ['gteq' => $from . ' 00:00:00'])
             ->addFieldToFilter('created_at', ['lteq' => $to . ' 23:59:59']);
        return $this;
    }
}