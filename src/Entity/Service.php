<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Service
 * @ORM\Table(name="Services", indexes={@ORM\Index(name="services_fk0", columns={"astrologer_id"}), @ORM\Index(name="services_fk1", columns={"product_id"})})
 * @ORM\Entity
 */
class Service
{
    /**
     * @var int
     * @Groups({"short", "long"})
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     * @Groups({"long"})
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var Astrologer
     *
     * @ORM\ManyToOne(targetEntity="Astrologer", inversedBy="services")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="astrologer_id", referencedColumnName="id")
     * })
     */
    private $astrologer;

    /**
     * @var Product
     * @Groups({"short", "long"})
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAstrologer(): ?Astrologer
    {
        return $this->astrologer;
    }

    public function setAstrologer(?Astrologer $astrologer): self
    {
        $this->astrologer = $astrologer;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }


}
