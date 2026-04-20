<?php
namespace MagentoVlogs\BannerSlider\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'MagentoVlogs_BannerSlider::all_banners';

    protected $resultPageFactory;
    protected $_coreRegistry;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegistry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry     = $coreRegistry;
        parent::__construct($context);
    }

    public function execute()
    {
        $id    = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create(
            \MagentoVlogs\BannerSlider\Model\Banner::class
        );

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(
                    __('This banner no longer exists.')
                );
                return $this->resultRedirectFactory->create()
                    ->setPath('*/*/');
            }
        }

        // Required for Delete button in Block classes
        $this->_coreRegistry->register('banners_slider', $model);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MagentoVlogs_BannerSlider::all_banners');
        $resultPage->addBreadcrumb(__('Banners Slider'), __('Banners Slider'));
        $resultPage->addBreadcrumb(
            $id ? __('Edit Banner') : __('New Banner'),
            $id ? __('Edit Banner') : __('New Banner')
        );
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId()
                ? __('Edit Banner: %1', $model->getName())
                : __('New Banner')
        );

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(
            'MagentoVlogs_BannerSlider::banner_read'
        ) || $this->_authorization->isAllowed(
            'MagentoVlogs_BannerSlider::banner_create'
        );
    }
}