<?php
namespace MagentoVlogs\BannerSlider\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;
use MagentoVlogs\BannerSlider\Model\ResourceModel\Banner\CollectionFactory;
use MagentoVlogs\BannerSlider\Model\ResourceModel\Group\CollectionFactory 
    as GroupCollectionFactory;
use Magento\Framework\UrlInterface;

class BannerSlider extends Template implements BlockInterface
{
    protected $_template = 'MagentoVlogs_BannerSlider::widget/banner-slider.phtml';

    protected $bannerCollectionFactory;
    protected $groupCollectionFactory;

    public function __construct(
        Context $context,
        CollectionFactory $bannerCollectionFactory,
        GroupCollectionFactory $groupCollectionFactory,
        array $data = []
    ) {
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        $this->groupCollectionFactory  = $groupCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get banners by position
     */
    public function getBannersByPosition($position)
    {
        $today = date('Y-m-d');

        $collection = $this->bannerCollectionFactory->create()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter(
                ['start_date', 'start_date'],
                [
                    ['null' => true],
                    ['lteq' => $today]
                ]
            )
            ->addFieldToFilter(
                ['end_date', 'end_date'],
                [
                    ['null' => true],
                    ['gteq' => $today]
                ]
            )
            ->setOrder('display_order', 'ASC');

        return $collection;
    }

    /**
     * Get image URL for banner
     */
    public function getImageUrl($imageName)
    {
        return $this->_storeManager->getStore()->getBaseUrl(
            UrlInterface::URL_TYPE_MEDIA
        ) . 'magentovlogs/banners_slider/' . $imageName;
    }
}