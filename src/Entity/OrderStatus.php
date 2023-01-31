<?php

namespace App\Entity;

use App\Repository\OrderStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderStatusRepository::class)
 */
class OrderStatus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Ordered::class, mappedBy="orderStatus")
     */
    private $OrderId;

    public function __toString()
    {
        return $this->status;
    }

    public function __construct()
    {
        $this->OrderId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Ordered>
     */
    public function getOrderId(): Collection
    {
        return $this->OrderId;
    }

    public function addOrderId(Ordered $orderId): self
    {
        if (!$this->OrderId->contains($orderId)) {
            $this->OrderId[] = $orderId;
            $orderId->setOrderStatus($this);
        }

        return $this;
    }

    public function removeOrderId(Ordered $orderId): self
    {
        if ($this->OrderId->removeElement($orderId)) {
            // set the owning side to null (unless already changed)
            if ($orderId->getOrderStatus() === $this) {
                $orderId->setOrderStatus(null);
            }
        }

        return $this;
    }
}
