<?php
namespace MagentoVlogs\BannerSlider\Controller\Adminhtml\Group;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'MagentoVlogs_BannerSlider::group_delete';

    /**
     * Delete Group
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $groupId = (int)$this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if (!$groupId) {
            $this->messageManager->addErrorMessage(
                __('Group doesn\'t exist any longer.')
            );
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $model = $this->_objectManager->create(
                \MagentoVlogs\BannerSlider\Model\Group::class
            );
            $model->load($groupId);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(
                    __('This Group no longer exists.')
                );
                return $resultRedirect->setPath('*/*/');
            }

            $model->delete();
            $this->messageManager->addSuccessMessage(
                __('The Group has been deleted successfully.')
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
            'MagentoVlogs_BannerSlider::group_delete'
        );
    }
}