<?php
namespace MagentoVlogs\BannerSlider\Api;

interface BannerRepositoryInterface
{
    /**
     * Get banners by position
     *
     * @param string $position
     * @return array
     */
    public function getByPosition($position);

    /**
     * Get all active banners
     *
     * @return array
     */
    public function getActiveBanners();
}