<?php

namespace Vette\Shutterstock\Domain\Model\Shutterstock;

/**
 * Abstract Asset
 */
class AbstractAsset
{

    /**
     * @var string
     */
    protected $id;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var int
     */
    protected $width;


    /**
     * AbstractAsset constructor.
     *
     * @param string $id
     * @param int $height
     * @param int $width
     */
    public function __construct(string $id, int $height, int $width)
    {
        $this->id = $id;
        $this->height = $height;
        $this->width = $width;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return self
     */
    public function setHeight(int $height): self
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return self
     */
    public function setWidth(int $width): self
    {
        $this->width = $width;
        return $this;
    }
}
