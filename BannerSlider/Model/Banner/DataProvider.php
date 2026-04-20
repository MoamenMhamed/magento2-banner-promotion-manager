<?php
namespace MagentoVlogs\BannerSlider\Model\Banner;

use MagentoVlogs\BannerSlider\Model\ResourceModel\Banner\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;
use MagentoVlogs\BannerSlider\Model\Banner\FileInfo;
use Magento\Framework\Filesystem;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \MagentoVlogs\BannerSlider\Model\ResourceModel\Banner\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var Filesystem
     */
    private $fileInfo;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $bannerCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct($name, $primaryFieldName, $requestFieldName, CollectionFactory $bannerCollectionFactory, DataPersistorInterface $dataPersistor, array $meta = [], array $data = [])
    {
        $this->collection = $bannerCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData))
        {
            return $this->loadedData;
        }
        $items = $this
            ->collection
            ->getItems();
        /** @var \MagentoVlogs\BannerSlider\Model\Banner $banner */
        foreach ($items as $banner)
        {
            $banner = $this->convertValues($banner);
            $this->loadedData[$banner->getId() ] = $banner->getData();
        }

        // Used from the Save action
        $data = $this
            ->dataPersistor
            ->get('banners_slider');
        if (!empty($data))
        {
            $banner = $this
                ->collection
                ->getNewEmptyItem();
            $banner->setData($data);
            $this->loadedData[$banner->getId() ] = $banner->getData();
            $this
                ->dataPersistor
                ->clear('banners_slider');
        }

        return $this->loadedData;
    }

    /**
     * Converts image data to acceptable for rendering format
     *
     * @param \MagentoVlogs\BannerSlider\Model\Banner $banner
     * @return \MagentoVlogs\BannerSlider\Model\Banner $banner
     */
    private function convertValues($banner)
    {
        // Handle desktop image
        $fileName = $banner->getImage();
        if ($fileName && $this->getFileInfo()
            ->isExist($fileName))
        {
            $stat = $this->getFileInfo()
                ->getStat($fileName);
            $mime = $this->getFileInfo()
                ->getMimeType($fileName);
            $banner->setImage([['name' => $fileName, 'url' => $banner->getImageUrl() , 'size' => isset($stat) ? $stat['size'] : 0, 'type' => $mime, ]]);
        }

        // Handle mobile image
        $mobileFileName = $banner->getMobileImage();
        if ($mobileFileName && $this->getFileInfo()
            ->isExist($mobileFileName))
        {
            $stat = $this->getFileInfo()
                ->getStat($mobileFileName);
            $mime = $this->getFileInfo()
                ->getMimeType($mobileFileName);
            $banner->setMobileImage([['name' => $mobileFileName, 'url' => $banner->getMobileImageUrl() , 'size' => isset($stat) ? $stat['size'] : 0, 'type' => $mime, ]]);
        }

        return $banner;
    }

    /**
     * Get FileInfo instance
     *
     * @return FileInfo
     *
     * @deprecated 101.1.0
     */
    private function getFileInfo()
    {
        if ($this->fileInfo === null)
        {
            $this->fileInfo = ObjectManager::getInstance()
                ->get(FileInfo::class);
        }
        return $this->fileInfo;
    }
}

