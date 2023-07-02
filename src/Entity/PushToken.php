<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity(repositoryClass="\Bone\Notification\PushToken\Repository\PushTokenRepository")
 */
class PushToken implements JsonSerializable
{
    /**
     * @var int $id
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string $token
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $token;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $data = [
            'id' => $this->getId(),
            'token' => $this->getToken(),
        ];

        return $data;
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return \json_encode($this->toArray());
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->jsonSerialize();
    }
}
