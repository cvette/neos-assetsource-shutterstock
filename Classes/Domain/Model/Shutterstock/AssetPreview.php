<?php

namespace Vette\Shutterstock\Domain\Model\Shutterstock;

use Neos\Flow\Http\Uri;

/**
 * Asset Preview
 */
class AssetPreview extends AbstractAsset
{
    /**
     * @var Uri
     */
    protected $url;


    /**
     * Creates an AssetPreview from API response
     *
     * @param string $key
     * @param array $assetResponse
     * @return AssetPreview
     */
    public static function createFromResponse(string $key, array $assetResponse): AssetPreview
    {
        $assetPreview = new AssetPreview($key, $assetResponse['height'], $assetResponse['width']);
        $assetPreview->setUrl(new Uri($assetResponse['url']));

        return $assetPreview;
    }

    /**
     * @return Uri
     */
    public function getUrl(): Uri
    {
        return $this->url;
    }

    /**
     * @param Uri $url
     * @return self
     */
    public function setUrl(Uri $url): self
    {
        $this->url = $url;
        return $this;
    }
}
