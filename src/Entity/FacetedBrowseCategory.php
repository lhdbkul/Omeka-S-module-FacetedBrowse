<?php
namespace FacetedBrowse\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Omeka\Entity\AbstractEntity;
use Omeka\Entity\Site;
use Omeka\Entity\User;

/**
 * @Entity
 * @HasLifecycleCallbacks
 */
class FacetedBrowseCategory extends AbstractEntity
{
    /**
     * @Id
     * @Column(
     *     type="integer",
     *     options={
     *         "unsigned"=true
     *     }
     * )
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(
     *     targetEntity="Omeka\Entity\User"
     * )
     * @JoinColumn(
     *     nullable=true,
     *     onDelete="SET NULL"
     * )
     */
    protected $owner;

    /**
     * @ManyToOne(
     *     targetEntity="Omeka\Entity\Site"
     * )
     * @JoinColumn(
     *     nullable=false,
     *     onDelete="CASCADE"
     * )
     */
    protected $site;

    /**
     * @Column(
     *     type="datetime",
     *     nullable=false
     * )
     */
    protected $created;

    /**
     * @Column(
     *     type="datetime",
     *     nullable=true
     * )
     */
    protected $modified;

    /**
     * @Column(
     *     type="string",
     *     length=255,
     *     nullable=false
     * )
     */
    protected $name;

    /**
     * @Column(
     *     type="text",
     *     nullable=false
     * )
     */
    protected $query;

    /**
     * @Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected $sortBy;

    /**
     * @Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected $sortOrder;

    /**
     * @Column(
     *     type="text",
     *     nullable=true
     * )
     */
    protected $helperText;

    /**
     * @Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected $helperTextButtonLabel;

    /**
     * @Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    protected $valueFacetMode;

    /**
     * @ManyToOne(
     *     targetEntity="FacetedBrowse\Entity\FacetedBrowsePage",
     *     inversedBy="categories"
     * )
     * @JoinColumn(
     *     nullable=false,
     *     onDelete="CASCADE"
     * )
     */
    protected $page;

    /**
     * @Column(
     *     type="integer",
     *     nullable=false
     * )
     */
    protected $position;

    /**
     * @OneToMany(
     *     targetEntity="FacetedBrowseFacet",
     *     mappedBy="category",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove", "detach"},
     *     indexBy="id"
     * )
     * @OrderBy({"position" = "ASC"})
     */
    protected $facets;

    /**
     * @OneToMany(
     *     targetEntity="FacetedBrowseColumn",
     *     mappedBy="category",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove", "detach"},
     *     indexBy="id"
     * )
     * @OrderBy({"position" = "ASC"})
     */
    protected $columns;

    public function __construct()
    {
        $this->facets = new ArrayCollection;
        $this->columns = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setOwner(?User $owner = null) : void
    {
        $this->owner = $owner;
    }

    public function getOwner() : ?User
    {
        return $this->owner;
    }

    public function setSite(Site $site) : void
    {
        $this->site = $site;
    }

    public function getSite() : Site
    {
        return $this->site;
    }

    public function setCreated(DateTime $created) : void
    {
        $this->created = $created;
    }

    public function getCreated() : DateTime
    {
        return $this->created;
    }

    public function setModified(DateTime $modified) : void
    {
        $this->modified = $modified;
    }

    public function getModified() : ?DateTime
    {
        return $this->modified;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setQuery(string $query) : void
    {
        $this->query = $query;
    }

    public function getQuery() : string
    {
        return $this->query;
    }

    public function setSortBy(?string $sortBy) : void
    {
        $this->sortBy = $sortBy;
    }

    public function getSortBy() : ?string
    {
        return $this->sortBy;
    }

    public function setSortOrder(?string $sortOrder) : void
    {
        $this->sortOrder = $sortOrder;
    }

    public function getSortOrder() : ?string
    {
        return $this->sortOrder;
    }

    public function setHelperText(?string $helperText) : void
    {
        $this->helperText = $helperText;
    }

    public function getHelperText() : ?string
    {
        return $this->helperText;
    }

    public function setHelperTextButtonLabel(?string $helperTextButtonLabel) : void
    {
        $this->helperTextButtonLabel = $helperTextButtonLabel;
    }

    public function getHelperTextButtonLabel() : ?string
    {
        return $this->helperTextButtonLabel;
    }

    public function setValueFacetMode(?string $valueFacetMode) : void
    {
        $this->valueFacetMode = $valueFacetMode;
    }

    public function getValueFacetMode() : ?string
    {
        return $this->valueFacetMode;
    }

    public function setPage(FacetedBrowsePage $page) : void
    {
        $this->page = $page;
    }

    public function getPage() : FacetedBrowsePage
    {
        return $this->page;
    }

    public function setPosition(int $position) : void
    {
        $this->position = $position;
    }

    public function getPosition() : int
    {
        return $this->position;
    }

    public function getFacets() : Collection
    {
        return $this->facets;
    }

    public function getColumns() : Collection
    {
        return $this->columns;
    }

    /**
     * @PrePersist
     */
    public function prePersist(LifecycleEventArgs $eventArgs) : void
    {
        $this->setCreated(new DateTime('now'));
    }
}
