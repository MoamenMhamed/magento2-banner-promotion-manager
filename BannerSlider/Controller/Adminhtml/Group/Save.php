<?php
namespace MagentoVlogs\BannerSlider\Controller\Adminhtml\Group;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    protected $dataPersistor;

    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }
        $id = $this->getRequest()->getParam('id');

        if (empty($data['id'])) {
            $data['id'] = null;
        }

        $model = $this->_objectManager
            ->create(\MagentoVlogs\BannerSlider\Model\Group::class)
            ->load($id);

        if (!$model->getId() && $id) {
            $this->messageManager->addErrorMessage(__('This group no longer exists.'));
            return $resultRedirect->setPath('*/*/');
        }

        $model->setData($data);

        try {
            $model->save();
            $this->messageManager->addSuccessMessage(__('Group saved successfully!'));
            $this->dataPersistor->clear('group_banners_slider');

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
            }
            return $resultRedirect->setPath('*/*/');

        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('Something went wrong while saving the group.')
            );
        }

        $this->dataPersistor->set('group_banners_slider', $data);
        return $resultRedirect->setPath('*/*/edit', [
            'id' => $this->getRequest()->getParam('id')
        ]);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(
            'MagentoVlogs_BannerSlider::group_update'
        ) || $this->_authorization->isAllowed(
            'MagentoVlogs_BannerSlider::group_create'
        );
    }
}