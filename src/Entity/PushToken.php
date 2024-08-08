<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Entity;

use Bone\BoneDoctrine\Traits\HasCreatedAtDate;
use Bone\BoneDoctrine\Traits\HasId;
use Bone\BoneDoctrine\Traits\HasUpdatedAtDate;
use Del\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity]
class PushToken implements JsonSerializable
{
    use HasCreatedAtDate;
    use HasId;
    use HasUpdatedAtDate;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $token = '';

    #[ORM\OneToOne(targetEntity: 'Del\Entity\User')]
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
        $data = [
            'token' => $this->getToken(),
            'user' => $this->user->getId(),
        ];

        return $data;
    }

    public function jsonSerialize(): string
    {
        return \json_encode($this->toArray());
    }

    public function __toString(): string
    {
        return $this->jsonSerialize();
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
