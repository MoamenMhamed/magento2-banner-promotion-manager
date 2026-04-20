<?php
namespace MagentoVlogs\BannerSlider\Controller\Adminhtml\Group;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use MagentoVlogs\BannerSlider\Model\ResourceModel\Group\CollectionFactory;

class MassDelete extends Action
{
    const ADMIN_RESOURCE = 'MagentoVlogs_BannerSlider::group_delete';

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

        foreach ($collection as $group) {
            $group->delete();
            $deleted++;
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 group(s) have been deleted.', $deleted)
        );

        return $this->resultRedirectFactory->create()
            ->setPath('*/*/index');
    }
}