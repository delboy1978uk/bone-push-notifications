<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Entity;

use Bone\BoneDoctrine\Traits\HasCreatedAtDate;
use Bone\BoneDoctrine\Traits\HasId;
use Bone\BoneDoctrine\Traits\HasUpdatedAtDate;
use Del\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 */
class PushToken implements JsonSerializable
{
    use HasCreatedAtDate;
    use HasId;
    use HasUpdatedAtDate;

    /**
     * @var string $token
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private string $token = '';

    /**
     * @ORM\ManyToOne(targetEntity="Del\Entity\User")
     */
    private User $user;

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
            'token' => $this->getToken(),
            'user' => $this->user->getId(),
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

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
