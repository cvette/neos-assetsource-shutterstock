<?php

namespace Vette\Shutterstock\Domain\Model\Shutterstock\Result;

use Vette\Shutterstock\Domain\Model\Shutterstock\Image;
use Neos\Flow\Annotations as Flow;

/**
 * ImageSearchResult
 *
 * @Flow\Proxy(enabled=false)
 */
class ImageSearchResult extends PaginatedResult
{

    /**
     * Creates an ImageSearchResult from API response
     *
     * @param array $response
     * @return ImageSearchResult
     */
    public static function createFromResponse(array $response): ImageSearchResult
    {
        $result = new self();
        $result->setPerPage($response['per_page']);
        $result->setPage($response['page']);
        $result->setTotalCount($response['total_count']);
        $result->setSearchId($response['search_id']);

        $images = array();
        foreach ($response['data'] as $data) {
            $images[] = Image::createFromResponse($data);
        }

        $result->setData($images);
        return $result;
    }
}
