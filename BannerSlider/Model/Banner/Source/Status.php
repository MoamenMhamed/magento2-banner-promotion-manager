<?php

namespace MagentoVlogs\BannerSlider\Model\Banner\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 */
class Status implements OptionSourceInterface
{
    /**
     * @var \MagentoVlogs\BannerSlider\Model\Banner
     */
    protected $banner;

    /**
     * Constructor
     *
     * @param \MagentoVlogs\BannerSlider\Model\Banner $banner
     */
    public function __construct(\MagentoVlogs\BannerSlider\Model\Banner $banner)
    {
        $this->banner = $banner;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this
            ->banner
            ->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value)
        {
            $options[] = ['label' => $value, 'value' => $key, ];
        }
        return $options;
    }
}

