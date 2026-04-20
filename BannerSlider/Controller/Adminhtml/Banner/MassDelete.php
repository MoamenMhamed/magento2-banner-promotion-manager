<?php
namespace MagentoVlogs\BannerSlider\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use MagentoVlogs\BannerSlider\Model\ResourceModel\Banner\CollectionFactory;

class MassDelete extends Action
{
    const ADMIN_RESOURCE = 'MagentoVlogs_BannerSlider::banner_delete';

    protected $filter;
    protected $collectionFactory;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter            = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection    = $this->filter->getCollection(
            $this->collectionFactory->create()
        );
        $deleted = 0;

        foreach ($collection as $banner) {
            $banner->delete();
            $deleted++;
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 banner(s) have been deleted.', $deleted)
        );

        return $this->resultRedirectFactory->create()
            ->setPath('*/*/index');
    }
}