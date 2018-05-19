<?php
namespace Vette\Shutterstock\Domain\Model\AssetSource\Shutterstock;

use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Point;
use Neos\Media\Domain\Model\AssetSource\AssetProxy\AssetProxyInterface;
use Neos\Media\Domain\Model\AssetSource\AssetProxy\HasRemoteOriginalInterface;
use Neos\Media\Domain\Model\AssetSource\AssetSourceInterface;
use Neos\Media\Domain\Model\ImportedAsset;
use Neos\Media\Domain\Repository\ImportedAssetRepository;
use Psr\Http\Message\UriInterface;
use Neos\Flow\Annotations as Flow;
use Vette\Shutterstock\Domain\Model\Shutterstock\Image;

/**
 * ShutterstockAssetProxy
 */
class ShutterstockAssetProxy implements AssetProxyInterface, HasRemoteOriginalInterface
{
    /**
     * @var ImagineInterface
     * @Flow\Inject(lazy = false)
     */
    protected $imagineService;

    /**
     * @var ShutterstockAssetSource
     */
    private $assetSource;

    /**
     * @var ImportedAsset
     */
    private $importedAsset;

    /**
     * @var Image
     */
    private $image;


    /**
     * ShutterstockAssetProxy constructor.
     *
     * @param Image $image
     * @param ShutterstockAssetSource $assetSource
     */
    public function __construct(Image $image, ShutterstockAssetSource $assetSource)
    {
        $this->image = $image;
        $this->assetSource = $assetSource;
        $this->importedAsset = (new ImportedAssetRepository())->findOneByAssetSourceIdentifierAndRemoteAssetIdentifier($assetSource->getIdentifier(), $this->getIdentifier());
    }

    public function getAssetSource(): AssetSourceInterface
    {
        return $this->assetSource;
    }

    public function getIdentifier(): string
    {
        return $this->image->getId();
    }

    public function getLabel(): string
    {
        return $this->image->getDescription();
    }

    public function getFilename(): string
    {
        return basename($this->image->getAssetPreview('preview')->getUrl()->getPath());
    }

    public function getLastModified(): \DateTimeInterface
    {
        return $this->image->getAddedDate();
    }

    public function getFileSize(): int
    {
        return 0;
    }

    public function getMediaType(): string
    {
        return 'image/jpg';
    }

    public function getWidthInPixels(): ?int
    {
        return $this->image->getAssetPreview('preview')->getWidth();
    }

    public function getHeightInPixels(): ?int
    {
        return $this->image->getAssetPreview('preview')->getHeight();
    }

    public function getThumbnailUri(): ?UriInterface
    {
        return $this->image->getAssetPreview('huge_thumb')->getUrl();
    }

    public function getPreviewUri(): ?UriInterface
    {
        return $this->image->getAssetPreview('preview')->getUrl();
    }

    public function getImportStream()
    {
        if ($this->assetSource->isRemoveImageIdFromPreview()) {
            return $this->removeImageId();
        }

        return fopen($this->image->getAssetPreview('preview')->getUrl(), 'r');
    }

    /**
     * Crops the image preview so the image Id is not shown
     *
     * @return bool|resource
     */
    protected function removeImageId()
    {
        $fileHandle = fopen($this->image->getAssetPreview('preview')->getUrl(), 'r');
        $image = $this->imagineService->read($fileHandle);

        $width = $this->image->getAssetPreview('preview')->getWidth();
        $height = $this->image->getAssetPreview('preview')->getHeight();

        $image->crop(new Point(0,0), new Box($width, $height));
        $string = $image->get('jpg');

        $stream = fopen('php://memory','r+');
        fwrite($stream, $string);
        rewind($stream);

        return $stream;
    }

    public function getLocalAssetIdentifier(): ?string
    {
        return $this->importedAsset instanceof ImportedAsset ? $this->importedAsset->getLocalAssetIdentifier() : '';
    }

    public function isImported(): bool
    {
        return $this->importedAsset !== null;
    }
}
