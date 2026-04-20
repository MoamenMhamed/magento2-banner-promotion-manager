<?php
namespace MagentoVlogs\BannerSlider\Controller\Adminhtml\Banner;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'MagentoVlogs_BannerSlider::banner_delete';

    /**
     * Delete Banner
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $bannerId = (int)$this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$bannerId) {
            $this->messageManager->addErrorMessage(
                __('Banner doesn\'t exist any longer.')
            );
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $model = $this->_objectManager->create(
                \MagentoVlogs\BannerSlider\Model\Banner::class
            );
            $model->load($bannerId);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(
                    __('This banner no longer exists.')
                );
                return $resultRedirect->setPath('*/*/');
            }

            $model->delete();
            $this->messageManager->addSuccessMessage(
                __('The Banner has been deleted successfully.')
            );
            return $resultRedirect->setPath('*/*/');

        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            return $resultRedirect->setPath('*/*/');
        }
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(
            'MagentoVlogs_BannerSlider::banner_delete'
        );
    }
}