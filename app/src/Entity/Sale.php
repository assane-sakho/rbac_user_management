<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sale
 *
 * @ORM\Table(name="sales", indexes={@ORM\Index(name="fk_sale_article_store_1", columns={"article_store_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\SaleRepository")
 */
class Sale
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price;

    /**
     * @var int|null
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="client_reference", type="string", length=255, nullable=true)
     */
    private $clientReference;

    /**
     * @var \ArticleStore
     *
     * @ORM\ManyToOne(targetEntity="ArticleStore")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article_store_id", referencedColumnName="id")
     * })
     */
    private $articleStore;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getClientReference(): ?string
    {
        return $this->clientReference;
    }

    public function setClientReference(?string $clientReference): self
    {
        $this->clientReference = $clientReference;

        return $this;
    }

    public function getArticleStore(): ?ArticleStore
    {
        return $this->articleStore;
    }

    public function setArticleStore(?ArticleStore $articleStore): self
    {
        $this->articleStore = $articleStore;

        return $this;
    }


}
