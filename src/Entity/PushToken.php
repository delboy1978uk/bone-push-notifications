<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Entity;

use Bone\BoneDoctrine\Traits\HasCreatedAtDate;
use Bone\BoneDoctrine\Traits\HasId;
use Bone\BoneDoctrine\Traits\HasUpdatedAtDate;
use Del\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use JsonException;
use JsonSerializable;
use function json_encode;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->getToken(),
            'user' => $this->user->getId(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @throws JsonException
     */
    public function __toString(): string
    {
        return json_encode($this->jsonSerialize(), JSON_THROW_ON_ERROR);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
