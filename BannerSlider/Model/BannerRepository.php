<?php
namespace MagentoVlogs\BannerSlider\Model;

use MagentoVlogs\BannerSlider\Api\BannerRepositoryInterface;
use MagentoVlogs\BannerSlider\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class BannerRepository implements BannerRepositoryInterface
{
    protected $collectionFactory;
    protected $storeManager;

    public function __construct(
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager      = $storeManager;
    }

    public function getByPosition($position)
    {
        return $this->getBanners($position);
    }

    public function getActiveBanners()
    {
        return $this->getBanners();
    }

    private function getBanners($position = null)
    {
        $today      = date('Y-m-d');
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter(
                ['start_date', 'start_date'],
                [['null' => true], ['lteq' => $today]]
            )
            ->addFieldToFilter(
                ['end_date', 'end_date'],
                [['null' => true], ['gteq' => $today]]
            )
            ->setOrder('display_order', 'ASC');

        if ($position) {
            $collection->addFieldToFilter('position', $position);
        }

        $mediaUrl = $this->storeManager->getStore()
            ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);

        $result = [];
        foreach ($collection as $banner) {
            $result[] = [
                'id'               => (int)$banner->getId(),
                'name'             => $banner->getName(),
                'title'            => $banner->getTitle(),
                'description'      => $banner->getDescription(),
                'image_url'        => $mediaUrl . 'magentovlogs/banners_slider/' 
                                      . $banner->getImage(),
                'mobile_image_url' => $banner->getMobileImage()
                    ? $mediaUrl . 'magentovlogs/banners_slider/' 
                      . $banner->getMobileImage()
                    : null,
                'url'              => $banner->getUrl(),
                'link_text'        => $banner->getLinkText(),
                'background_color' => $banner->getBackgroundColor(),
                'text_color'       => $banner->getTextColor(),
                'position'         => $banner->getPosition(),
                'display_order'    => (int)$banner->getDisplayOrder(),
            ];
        }

        return $result;
    }
}