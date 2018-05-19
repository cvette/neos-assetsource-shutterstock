<?php

namespace Vette\Shutterstock\Domain\Model\Shutterstock;

use http\Url;


/**
 * Contributor
 */
class Contributor
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var string
     */
    protected $about;

    /**
     * @var array
     */
    protected $equipment;

    /**
     * @var array
     */
    protected $contributorType;

    /**
     * @var array
     */
    protected $styles;

    /**
     * @var array
     */
    protected $subjects;

    /**
     * @var string
     */
    protected $website;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var Url
     */
    protected $portfolioUrl;

    /**
     * @var array
     */
    protected $socialMedia;


    /**
     * ShutterstockContributor constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
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
     * @return string
     */
    public function getAbout(): string
    {
        return $this->about;
    }

    /**
     * @param string $about
     * @return self
     */
    public function setAbout(string $about): self
    {
        $this->about = $about;
        return $this;
    }

    /**
     * @return array
     */
    public function getEquipment(): array
    {
        return $this->equipment;
    }

    /**
     * @param array $equipment
     * @return self
     */
    public function setEquipment(array $equipment): self
    {
        $this->equipment = $equipment;
        return $this;
    }

    /**
     * @return array
     */
    public function getContributorType(): array
    {
        return $this->contributorType;
    }

    /**
     * @param array $contributorType
     * @return self
     */
    public function setContributorType(array $contributorType): self
    {
        $this->contributorType = $contributorType;
        return $this;
    }

    /**
     * @return array
     */
    public function getStyles(): array
    {
        return $this->styles;
    }

    /**
     * @param array $styles
     * @return self
     */
    public function setStyles(array $styles): self
    {
        $this->styles = $styles;
        return $this;
    }

    /**
     * @return array
     */
    public function getSubjects(): array
    {
        return $this->subjects;
    }

    /**
     * @param array $subjects
     * @return self
     */
    public function setSubjects(array $subjects): self
    {
        $this->subjects = $subjects;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * @param string $website
     * @return self
     */
    public function setWebsite(string $website): self
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     * @return self
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return Url
     */
    public function getPortfolioUrl(): Url
    {
        return $this->portfolioUrl;
    }

    /**
     * @param Url $portfolioUrl
     * @return self
     */
    public function setPortfolioUrl(Url $portfolioUrl): self
    {
        $this->portfolioUrl = $portfolioUrl;
        return $this;
    }

    /**
     * @return array
     */
    public function getSocialMedia(): array
    {
        return $this->socialMedia;
    }

    /**
     * @param array $socialMedia
     * @return self
     */
    public function setSocialMedia(array $socialMedia): self
    {
        $this->socialMedia = $socialMedia;
        return $this;
    }
}
