<?php
namespace Vette\Shutterstock\Domain\Model\AssetSource\Shutterstock;

use Neos\Flow\Http\Uri;
use Neos\Media\Domain\Model\AssetSource\AssetProxy\AssetProxyInterface;
use Neos\Media\Domain\Model\AssetSource\AssetProxy\HasRemoteOriginalInterface;
use Neos\Media\Domain\Model\AssetSource\AssetSourceInterface;
use Neos\Media\Domain\Model\ImportedAsset;
use Neos\Media\Domain\Repository\ImportedAssetRepository;
use Psr\Http\Message\UriInterface;

class ShutterstockAssetProxy implements AssetProxyInterface, HasRemoteOriginalInterface
{

    /**
     * @var ShutterstockAssetSource
     */
    private $assetSource;

    /**
     * @var ImportedAsset
     */
    private $importedAsset;

    /**
     * @var array
     */
    private $shutterstockData;


    /**
     * ShutterstockAssetProxy constructor.
     *
     * @param array $shutterstockData
     * @param ShutterstockAssetSource $assetSource
     */
    public function __construct(array $shutterstockData, ShutterstockAssetSource $assetSource)
    {
        $this->shutterstockData = $shutterstockData;
        $this->assetSource = $assetSource;
        $this->importedAsset = (new ImportedAssetRepository())->findOneByAssetSourceIdentifierAndRemoteAssetIdentifier($assetSource->getIdentifier(), $this->getIdentifier());
    }

    public function getAssetSource(): AssetSourceInterface
    {
        return $this->assetSource;
    }

    public function getIdentifier(): string
    {
        return $this->shutterstockData['id'];
    }

    public function getLabel(): string
    {
        return $this->shutterstockData['description'];
    }

    public function getFilename(): string
    {
        return basename($this->shutterstockData['assets']['preview']['url']);
    }

    public function getLastModified(): \DateTimeInterface
    {
        return new \DateTime($this->shutterstockData['added_date']);
    }

    public function getFileSize(): int
    {
        return $this->shutterstockData['assets']['huge_jpg']['file_size'];
    }

    public function getMediaType(): string
    {
        return 'image/jpg';
    }

    public function getWidthInPixels(): ?int
    {
        return $this->shutterstockData['assets']['huge_jpg']['width'];
    }

    public function getHeightInPixels(): ?int
    {
        return $this->shutterstockData['assets']['huge_jpg']['height'];
    }

    public function getThumbnailUri(): ?UriInterface
    {
        return new Uri($this->shutterstockData['assets']['huge_thumb']['url']);
    }

    public function getPreviewUri(): ?UriInterface
    {
        return new Uri($this->shutterstockData['assets']['preview']['url']);
    }

    public function getImportStream()
    {
        return fopen($this->shutterstockData['assets']['preview']['url'], 'r');
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
