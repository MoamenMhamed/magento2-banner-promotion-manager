<?php
namespace MagentoVlogs\BannerSlider\Controller\Adminhtml\Group;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class InlineEdit extends \Magento\Backend\App\Action
{
    /** @var JsonFactory  */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $groupId) {
                    /** @var \MagentoVlogs\BannerSlider\Model\Group $model */
                    $model = $this->_objectManager->create('MagentoVlogs\BannerSlider\Model\Group');
                    $model->load($groupId);
                    try {
                        $model->setData(array_merge($model->getData(), $postItems[$groupId]));
                        $model->save();
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithGroupId(
                            $model,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Group name to error message
     *
     * @param \MagentoVlogs\BannerSlider\Model\Group $group
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithGroupId(\MagentoVlogs\BannerSlider\Model\Group $group, $errorText)
    {
        return '[Group ID: ' . $group->getId() . '] ' . $errorText;
    }

    /**
     * Authorization level of a basic admin session
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MagentoVlogs_BannerSlider::group_read') ||
        $this->_authorization->isAllowed('MagentoVlogs_BannerSlider::group_create');
    }
}