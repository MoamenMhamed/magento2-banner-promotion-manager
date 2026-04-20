<?php
namespace MagentoVlogs\BannerSlider\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Analytics Model
 * Represents a single analytics event (click, impression, conversion)
 */
class Analytics extends AbstractModel
{
    /**
     * Event types constants
     */
    const EVENT_TYPE_CLICK = 'click';
    const EVENT_TYPE_IMPRESSION = 'impression';
    const EVENT_TYPE_CONVERSION = 'conversion';

    /**
     * Analytics cache tag
     */
    const CACHE_TAG = 'magentovlogs_banners_slider_analytics';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'magentovlogs_banners_slider_analytics';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\MagentoVlogs\BannerSlider\Model\ResourceModel\Analytics::class);
    }

    /**
     * Get available event types
     *
     * @return array
     */
    public function getAvailableEventTypes()
    {
        return [
            self::EVENT_TYPE_CLICK => __('Click'),
            self::EVENT_TYPE_IMPRESSION => __('Impression'),
            self::EVENT_TYPE_CONVERSION => __('Conversion')
        ];
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->getData('id');
    }

    /**
     * Get Banner ID
     *
     * @return int
     */
    public function getBannerId()
    {
        return $this->getData('banner_id');
    }

    /**
     * Get Event Type
     *
     * @return string
     */
    public function getEventType()
    {
        return $this->getData('event_type');
    }

    /**
     * Get Customer ID
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    /**
     * Get Session ID
     *
     * @return string|null
     */
    public function getSessionId()
    {
        return $this->getData('session_id');
    }

    /**
     * Set Banner ID
     *
     * @param int $bannerId
     * @return $this
     */
    public function setBannerId($bannerId)
    {
        return $this->setData('banner_id', $bannerId);
    }

    /**
     * Set Event Type
     *
     * @param string $eventType
     * @return $this
     */
    public function setEventType($eventType)
    {
        return $this->setData('event_type', $eventType);
    }

    /**
     * Set Customer ID
     *
     * @param int|null $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        return $this->setData('customer_id', $customerId);
    }

    /**
     * Set Session ID
     *
     * @param string|null $sessionId
     * @return $this
     */
    public function setSessionId($sessionId)
    {
        return $this->setData('session_id', $sessionId);
    }
}