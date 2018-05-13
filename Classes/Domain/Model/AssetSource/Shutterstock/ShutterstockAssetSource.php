<?php
namespace Vette\Shutterstock\Domain\Model\AssetSource\Shutterstock;

use Neos\Media\Domain\Model\AssetSource\AssetProxyRepositoryInterface;
use Neos\Media\Domain\Model\AssetSource\AssetSourceInterface;
use Vette\Shutterstock\Domain\Service\ShutterstockClient;
use Neos\Flow\Annotations as Flow;

/**
 * Class ShutterstockAssetSource
 */
class ShutterstockAssetSource implements AssetSourceInterface
{
    /**
     * @var string
     */
    protected $assetSourceIdentifier;

    /**
     * @var array
     */
    protected $assetSourceOptions;

    /**
     * @var ShutterstockAssetProxyRepository
     */
    protected $assetProxyRepository;

    /**
     * @Flow\Inject
     * @var ShutterstockClient
     */
    protected $shutterstockClient;

    /**
     * @var bool
     */
    protected $removeImageIdFromPreview = true;


    /**
     * ShutterstockAssetSource constructor.
     *
     * @param string $assetSourceIdentifier
     * @param array $assetSourceOptions
     */
    public function __construct(string $assetSourceIdentifier, array $assetSourceOptions)
    {
        if (preg_match('/^[a-z][a-z0-9-]{0,62}[a-z]$/', $assetSourceIdentifier) !== 1) {
            throw new \InvalidArgumentException(sprintf('Invalid asset source identifier "%s". The identifier must match /^[a-z][a-z0-9-]{0,62}[a-z]$/', $assetSourceIdentifier), 1513329665);
        }

        $this->assetSourceIdentifier = $assetSourceIdentifier;
        $this->assetSourceOptions = $assetSourceOptions;
    }

    /**
     * Initialize Object
     */
    public function initializeObject()
    {
        if (isset($this->assetSourceOptions['apiUrl'])) {
            $this->shutterstockClient->setApiUrl($this->assetSourceOptions['apiUrl']);
        }

        if (isset($this->assetSourceOptions['queryParams'])) {
            $this->shutterstockClient->setQueryParams($this->assetSourceOptions['queryParams']);
        }

        if (isset($this->assetSourceOptions['removeImageIdFromPreview'])) {
            $this->removeImageIdFromPreview = $this->assetSourceOptions['removeImageIdFromPreview'];
        }

        $this->shutterstockClient->setClientKey($this->assetSourceOptions['clientKey']);
        $this->shutterstockClient->setClientSecret($this->assetSourceOptions['clientSecret']);
    }

    /**
     * @param string $assetSourceIdentifier
     * @param array $assetSourceOptions
     * @return AssetSourceInterface
     */
    public static function createFromConfiguration(string $assetSourceIdentifier, array $assetSourceOptions): AssetSourceInterface
    {
        return new static($assetSourceIdentifier, $assetSourceOptions);
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->assetSourceIdentifier;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->assetSourceOptions['label'];
    }

    /**
     * @return AssetProxyRepositoryInterface
     */
    public function getAssetProxyRepository(): AssetProxyRepositoryInterface
    {
        if ($this->assetProxyRepository === null) {
            $this->assetProxyRepository = new ShutterstockAssetProxyRepository($this);
        }

        return $this->assetProxyRepository;
    }

    /**
     * @return array
     */
    public function getAssetSourceOptions(): array
    {
        return $this->assetSourceOptions;
    }

    /**
     * @return ShutterstockClient
     */
    public function getClient(): ShutterstockClient
    {
        return $this->shutterstockClient;
    }

    /**
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isRemoveImageIdFromPreview(): bool
    {
        return $this->removeImageIdFromPreview;
    }

    /**
     * @param bool $removeImageDetailsFromPreview
     */
    public function setRemoveImageIdFromPreview(bool $removeImageIdFromPreview): void
    {
        $this->removeImageIdFromPreview = $removeImageIdFromPreview;
    }
}
