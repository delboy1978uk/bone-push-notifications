<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Collection;

use Bone\Notification\PushToken\Entity\PushToken;
use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use LogicException;

class PushTokenCollection extends ArrayCollection implements JsonSerializable
{
    /**
     * @param PushToken $pushToken
     * @return $this
     * @throws LogicException
     */
    public function update(PushToken $pushToken): PushTokenCollection
    {
        $key = $this->findKey($pushToken);

        if($key) {
            $this->offsetSet($key,$pushToken);

            return $this;
        }

        throw new LogicException('PushToken was not in the collection.');
    }

    /**
     * @param PushToken $pushToken
     */
    public function append(PushToken $pushToken): void
    {
        $this->add($pushToken);
    }

    /**
     * @return PushToken|null
     */
    public function current(): ?PushToken
    {
        return parent::current();
    }

    /**
     * @param PushToken $pushToken
     * @return int|null
     */
    public function findKey(PushToken $pushToken): ?int
    {
        $it = $this->getIterator();
        $it->rewind();

        while($it->valid()) {

            if($it->current()->getId() == $pushToken->getId()) {
                return $it->key();
            }

            $it->next();
        }

        return null;
    }

    /**
     * @param int $id
     * @return PushToken|null
     */
    public function findById(int $id): ?PushToken
    {
        $it = $this->getIterator();
        $it->rewind();

        while($it->valid()) {

            if($it->current()->getId() == $id) {
                return $it->current();
            }

            $it->next();
        }

        return null;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $collection = [];
        $it = $this->getIterator();
        $it->rewind();

        while($it->valid()) {
            /** @var PushToken $row */
            $row = $it->current();
            $collection[] = $row->toArray();
            $it->next();
        }

        return $collection;
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
