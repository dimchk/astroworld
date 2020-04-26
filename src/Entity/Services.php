<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Services
 *
 * @ORM\Table(name="Services", indexes={@ORM\Index(name="services_fk0", columns={"astrologer_id"}), @ORM\Index(name="services_fk1", columns={"product_id"})})
 * @ORM\Entity
 */
class Services
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var \Astrologers
     *
     * @ORM\ManyToOne(targetEntity="Astrologers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="astrologer_id", referencedColumnName="id")
     * })
     */
    private $astrologer;

    /**
     * @var \Products
     *
     * @ORM\ManyToOne(targetEntity="Products")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;


}
