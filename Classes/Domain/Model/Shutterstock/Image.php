<?php

namespace Vette\Shutterstock\Domain\Model\Shutterstock;


/**
 * Image
 */
class Image
{
    protected const IMAGE_TYPE_ILLUSTRATION = 'illustration';
    protected const IMAGE_TYPE_PHOTO = 'photo';
    protected const IMAGE_TYPE_VECTOR = 'vector';

    protected const ASSET_PREVIEW_KEYS = ['preview', 'small_thumb', 'large_thumb', 'huge_thumb'];

    /**
     * @var int
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $addedDate;

    /**
     * @var float
     */
    protected $aspect;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $imageType;

    /**
     * @var bool
     */
    protected $isAdult = false;

    /**
     * @var bool
     */
    protected $isIllustration = false;

    /**
     * @var array
     */
    protected $keywords;

    /**
     * @var string
     */
    protected $mediaType;

    /**
     * @var array
     */
    protected $categories;

    /**
     * @var Contributor
     */
    protected $contributor;

    /**
     * @var array
     */
    protected $assets;

    /**
     * @var array
     */
    protected $assetPreviews;


    /**
     * @param array $response
     * @return Image
     */
    public static function createFromResponse(array $response): Image
    {
        $image = new Image();
        $image->setId($response['id']);
        $image->setImageType($response['image_type']);
        $image->setAddedDate(new \DateTime($response['added_date']));
        $image->setAspect($response['aspect']);
        $image->setDescription($response['description']);
        $image->setIsAdult($response['is_adult']);

        foreach ($response['categories'] as $category) {
            $image->addCategory(new Category($category['id'], $category['name']));
        }

        if (isset($data['is_illustration'])) {
            $image->setIsIllustration($response['is_illustration']);
        }

        foreach ($response['assets'] as $key => $asset) {
            $image->addAsset(self::createAssetOrAssetPreviewFromResponse($key, $asset));
        }

        $image->setKeywords($response['keywords']);
        $image->setContributor(new Contributor($response['contributor']['id']));

        return $image;
    }

    /**
     * @param $key
     * @param $assetResponse
     * @return AbstractAsset
     */
    protected static function createAssetOrAssetPreviewFromResponse($key, $assetResponse): AbstractAsset
    {
        if (in_array($key, self::ASSET_PREVIEW_KEYS)) {
            return AssetPreview::createFromResponse($key, $assetResponse);
        } else {
            return Asset::createFromResponse($key, $assetResponse);
        }
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAddedDate(): \DateTime
    {
        return $this->addedDate;
    }

    /**
     * @param \DateTime $addedDate
     * @return self
     */
    public function setAddedDate(\DateTime $addedDate): self
    {
        $this->addedDate = $addedDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAspect()
    {
        return $this->aspect;
    }

    /**
     * @param mixed $aspect
     * @return self
     */
    public function setAspect($aspect): self
    {
        $this->aspect = $aspect;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageType(): string
    {
        return $this->imageType;
    }

    /**
     * @param string $imageType
     * @return self
     */
    public function setImageType(string $imageType): self
    {
        $this->imageType = $imageType;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAdult(): bool
    {
        return $this->isAdult;
    }

    /**
     * @param bool $isAdult
     * @return self
     */
    public function setIsAdult(bool $isAdult): self
    {
        $this->isAdult = $isAdult;
        return $this;
    }

    /**
     * @return bool
     */
    public function isIllustration(): bool
    {
        return $this->isIllustration;
    }

    /**
     * @param bool $isIllustration
     * @return self
     */
    public function setIsIllustration(bool $isIllustration): self
    {
        $this->isIllustration = $isIllustration;
        return $this;
    }

    /**
     * @return array
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }

    /**
     * @param array $keywords
     * @return self
     */
    public function setKeywords(array $keywords): self
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @return string
     */
    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    /**
     * @param string $mediaType
     * @return self
     */
    public function setMediaType(string $mediaType): self
    {
        $this->mediaType = $mediaType;
        return $this;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param array $categories
     * @return self
     */
    public function setCategories(array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @param Category $category
     * @return self
     */
    public function addCategory(Category $category): self
    {
        $this->categories[] = $category;
        return $this;
    }

    /**
     * @return Contributor
     */
    public function getContributor(): Contributor
    {
        return $this->contributor;
    }

    /**
     * @param Contributor $contributor
     * @return self
     */
    public function setContributor(Contributor $contributor): self
    {
        $this->contributor = $contributor;
        return $this;
    }

    /**
     * Adds an asset to this image
     *
     * @param AbstractAsset $asset
     * @return self
     */
    public function addAsset(AbstractAsset $asset): self
    {
        $id = $asset->getId();

        switch (true) {
            case $asset instanceof Asset:
                $this->assets[$id] = $asset;
                break;
            case $asset instanceof AssetPreview:
                $this->assetPreviews[$id] = $asset;
                break;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAssets(): array
    {
        return $this->assets;
    }

    /**
     * @return array
     */
    public function getAssetPreviews(): array
    {
        return $this->assetPreviews;
    }

    /**
     * @param $key
     * @return AssetPreview
     */
    public function getAssetPreview($key): AssetPreview
    {
        return $this->assetPreviews[$key];
    }

    /**
     * @param $key
     * @return Asset
     */
    public function getAsset($key): Asset
    {
        return $this->assets[$key];
    }
}
