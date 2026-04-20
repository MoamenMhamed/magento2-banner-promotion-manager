<?php
namespace MagentoVlogs\BannerSlider\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use MagentoVlogs\BannerSlider\Model\Banner\ImageUploader;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        ImageUploader $imageUploader
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        // print_r($data);
        // exit();

        if ($data) {
            $id = $this->getRequest()->getParam("id");

            if (empty($data["id"])) {
                $data["id"] = null;
            }
            // Handle desktop image
            $imageName = "";
            if (!empty($data["image"])) {
                if (is_array($data["image"])) {
                    $imageName = $data["image"][0]["name"];
                    $data["image"] = $imageName;
                }
            }
            // Handle mobile image
            $mobileImageName = "";
            if (!empty($data["mobile_image"])) {
                if (is_array($data["mobile_image"])) {
                    $mobileImageName = $data["mobile_image"][0]["name"];
                    $data["mobile_image"] = $mobileImageName;
                }
            }

            /** @var \MagentoVlogs\BannerSlider\Model\Banner $model */
            $model = $this->_objectManager
                ->create("MagentoVlogs\BannerSlider\Model\Banner")
                ->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(
                    __("This banner no longer exists.")
                );
                return $resultRedirect->setPath("*/*/");
            }

            $model->setData($data);

            try {
                $model->save();
                // Move images from tmp folder to final folder
                if ($imageName) {
                    $this->imageUploader->moveFileFromTmp($imageName);
                }
                if ($mobileImageName) {
                    $this->imageUploader->moveFileFromTmp($mobileImageName);
                }
                $this->messageManager->addSuccessMessage(
                    __("Banner saved successfully!")
                );
                $this->dataPersistor->clear("banners_slider");

                if ($this->getRequest()->getParam("back")) {
                    return $resultRedirect->setPath("*/*/edit", [
                        "id" => $model->getId(),
                    ]);
                }
                return $resultRedirect->setPath("*/*/");
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException(
                    $e,
                    __("Something went wrong while saving the banner.")
                );
            }

            $this->dataPersistor->set("banners_slider", $data);
            return $resultRedirect->setPath("*/*/edit", [
                "id" => $this->getRequest()->getParam("id"),
            ]);
        }
        return $resultRedirect->setPath("*/*/");
    }

    /**
     * Authorization level of a basic admin session
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(
            "MagentoVlogs_BannerSlider::banner_update"
        ) ||
            $this->_authorization->isAllowed(
                "MagentoVlogs_BannerSlider::banner_create"
            );
    }
}
