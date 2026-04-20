<?php
namespace MagentoVlogs\BannerSlider\Model;

use MagentoVlogs\BannerSlider\Model\Banner\FileInfo;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;

class Banner extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Banner cache tag
     */
    const CACHE_TAG = 'magentovlogs_banners_slider';

    /**#@+
     * Banner's statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MagentoVlogs\BannerSlider\Model\ResourceModel\Banner');
    }

    /**
     * Prepare banner's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * Retrieve the Image URL
     *
     * @param string $imageName
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getImageUrl($imageName = null)
    {
        $url = '';
        $image = $imageName;
        if (!$image) {
            $image = $this->getData('image');
        }
        if ($image) {
            if (is_string($image)) {
                $url = $this->_getStoreManager()->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ).FileInfo::ENTITY_MEDIA_PATH .'/'. $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }

    /**
     * Get StoreManagerInterface instance
     *
     * @return StoreManagerInterface
     */
    private function _getStoreManager()
    {
        if ($this->_storeManager === null) {
            $this->_storeManager = 
            ObjectManager::getInstance()->get(StoreManagerInterface::class);
        }
        return $this->_storeManager;
    }
    /**
     * Get Title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData('title');
    }

    /**
     * Get Description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getData('description');
    }

    /**
     * Get Mobile Image
     *
     * @return string|null
     */
    public function getMobileImage()
    {
        return $this->getData('mobile_image');
    }
    public function getMobileImageUrl()
    {
        $fileName = $this->getMobileImage();
        if (!$fileName) {
            return null;
        }
        return $this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . 'magentovlogs/banners_slider/' . $fileName;
    }
    

    /**
     * Get Link Text
     *
     * @return string|null
     */
    public function getLinkText()
    {
        return $this->getData('link_text');
    }

    /**
     * Get Background Color
     *
     * @return string|null
     */
    public function getBackgroundColor()
    {
        return $this->getData('background_color');
    }

    /**
     * Get Text Color
     *
     * @return string|null
     */
    public function getTextColor()
    {
        return $this->getData('text_color');
    }

    /**
     * Get Position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->getData('position');
    }

    /**
     * Get Display Order
     *
     * @return int
     */
    public function getDisplayOrder()
    {
        return $this->getData('display_order');
    }

    /**
     * Get Start Date
     *
     * @return string|null
     */
    public function getStartDate()
    {
        return $this->getData('start_date');
    }

    /**
     * Get End Date
     *
     * @return string|null
     */
    public function getEndDate()
    {
        return $this->getData('end_date');
    }

    /**
     * Get Click Count
     *
     * @return int
     */
    public function getClickCount()
    {
        return $this->getData('click_count') ?: 0;
    }

    /**
     * Get Impression Count
     *
     * @return int
     */
    public function getImpressionCount()
    {
        return $this->getData('impression_count') ?: 0;
    }

    /**
     * Increment click count
     *
     * @return $this
     */
    public function incrementClickCount()
    {
        $currentCount = $this->getClickCount();
        $this->setData('click_count', $currentCount + 1);
        return $this;
    }

    /**
     * Increment impression count
     *
     * @return $this
     */
    public function incrementImpressionCount()
    {
        $currentCount = $this->getImpressionCount();
        $this->setData('impression_count', $currentCount + 1);
        return $this;
    }

    /**
     * Check if banner is currently active (within date range)
     *
     * @return bool
     */
    public function isActive()
    {
        if (!$this->getStatus()) {
            return false;
        }

        $now = new \DateTime();
        
        $startDate = $this->getStartDate();
        if ($startDate) {
            $start = new \DateTime($startDate);
            if ($now < $start) {
                return false;
            }
        }

        $endDate = $this->getEndDate();
        if ($endDate) {
            $end = new \DateTime($endDate);
            if ($now > $end) {
                return false;
            }
        }

        return true;
    }
}