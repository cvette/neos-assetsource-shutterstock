<?php

namespace Vette\Shutterstock\Domain\Model\Shutterstock;

/**
 * Asset
 */
class Asset extends AbstractAsset
{

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var int
     */
    protected $dpi;

    /**
     * @var int
     */
    protected $fileSize;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var bool
     */
    protected $isLicensable = false;


    /**
     * Creates an Asset from API response
     *
     * @param string $key
     * @param array $assetResponse
     * @return Asset
     */
    public static function createFromResponse(string $key, array $assetResponse): Asset
    {
        $asset = new Asset($key, $assetResponse['width'], $assetResponse['height']);
        $asset->setDpi($assetResponse['dpi']);
        $asset->setFormat($assetResponse['format']);
        $asset->setFileSize($assetResponse['file_size']);
        $asset->setDisplayName($assetResponse['display_name']);
        $asset->setIsLicensable($assetResponse['is_licensable']);

        return $asset;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return self
     */
    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
     * @return int
     */
    public function getDpi(): int
    {
        return $this->dpi;
    }

    /**
     * @param int $dpi
     * @return self
     */
    public function setDpi(int $dpi): self
    {
        $this->dpi = $dpi;
        return $this;
    }

    /**
     * @return int
     */
    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    /**
     * @param int $fileSize
     * @return self
     */
    public function setFileSize(int $fileSize): self
    {
        $this->fileSize = $fileSize;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return self
     */
    public function setFormat(string $format): self
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLicensable(): bool
    {
        return $this->isLicensable;
    }

    /**
     * @param bool $isLicensable
     * @return self
     */
    public function setIsLicensable(bool $isLicensable): self
    {
        $this->isLicensable = $isLicensable;
        return $this;
    }
}
