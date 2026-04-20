<?php
namespace MagentoVlogs\BannerSlider\Model\Banner\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Banner Position Source Model
 * Positions based on real RayaShop.com homepage analysis
 */
class Position implements OptionSourceInterface
{
    // ===== HOMEPAGE TOP SECTION =====
    const HERO_TOP_BAR       = 'hero_top_bar';      // Group A: 1 card above hero slider
    const SECONDARY_LEFT     = 'secondary_left';    // Group B: 2 stacked cards, left of hero
    const HOMEPAGE_HERO      = 'homepage_hero';     // Group C: main slider, 5 slides
    const SECONDARY_RIGHT    = 'secondary_right';   // Group D: 2 stacked cards, right of hero

    // ===== PAYMENT PARTNERS SECTION =====
    const PARTNERS_LEFT      = 'partners_left';     // Group E: 2 stacked cards, left
    const PAYMENT_PARTNERS   = 'payment_partners';  // Group F: 1 banner, text animation by frontend
    const PARTNERS_RIGHT     = 'partners_right';    // Group G: 2 cards, Nour Betak rotates color

    // ===== BADGES SECTION =====
    const PROMO_BADGES       = 'promo_badges';      // Group H: 6 badge cards grid

    // ===== MID PAGE BANNERS (between product listings) =====
    const MID_PAGE_1         = 'mid_page_1';        // Group I: full width, 50% brands banner
    const MID_PAGE_2         = 'mid_page_2';        // Group J: full width, Samsung store banner

    // ===== OTHER PAGES =====
    const CATEGORY_TOP       = 'category_top';
    const CATEGORY_SIDEBAR   = 'category_sidebar';
    const PRODUCT_PAGE       = 'product_page';
    const CART_PAGE          = 'cart_page';
    const CHECKOUT_PAGE      = 'checkout_page';

    public function toOptionArray()
    {
        return [
            // --- Homepage Top ---
            ['value' => self::HERO_TOP_BAR,     'label' => __('Homepage - Top Bar (above hero)')],
            ['value' => self::SECONDARY_LEFT,   'label' => __('Homepage - Secondary Left (2 cards)')],
            ['value' => self::HOMEPAGE_HERO,    'label' => __('Homepage - Hero Slider (main, 5 slides)')],
            ['value' => self::SECONDARY_RIGHT,  'label' => __('Homepage - Secondary Right (2 cards)')],

            // --- Payment Partners ---
            ['value' => self::PARTNERS_LEFT,    'label' => __('Homepage - Partners Left (2 cards)')],
            ['value' => self::PAYMENT_PARTNERS, 'label' => __('Homepage - Payment Partners Center (1 banner)')],
            ['value' => self::PARTNERS_RIGHT,   'label' => __('Homepage - Partners Right (Nour Betak)')],

            // --- Badges ---
            ['value' => self::PROMO_BADGES,     'label' => __('Homepage - Promo Badges (6 cards grid)')],

            // --- Mid Page ---
            ['value' => self::MID_PAGE_1,       'label' => __('Homepage - Mid Page Banner 1 (50% brands)')],
            ['value' => self::MID_PAGE_2,       'label' => __('Homepage - Mid Page Banner 2 (Samsung store)')],

            // --- Other Pages ---
            ['value' => self::CATEGORY_TOP,     'label' => __('Category Page - Top Banner')],
            ['value' => self::CATEGORY_SIDEBAR, 'label' => __('Category Page - Sidebar')],
            ['value' => self::PRODUCT_PAGE,     'label' => __('Product Page - Banner')],
            ['value' => self::CART_PAGE,        'label' => __('Shopping Cart - Banner')],
            ['value' => self::CHECKOUT_PAGE,    'label' => __('Checkout - Banner')],
        ];
    }

    public function toArray()
    {
        $options = [];
        foreach ($this->toOptionArray() as $option) {
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }
}