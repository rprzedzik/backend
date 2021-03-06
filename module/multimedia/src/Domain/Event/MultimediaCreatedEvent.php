<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Multimedia\Domain\Event;

use Ergonode\Core\Domain\Entity\AbstractId;
use Ergonode\EventSourcing\Infrastructure\DomainEventInterface;
use Ergonode\Multimedia\Domain\Entity\MultimediaId;
use Ergonode\Multimedia\Domain\ValueObject\Hash;
use JMS\Serializer\Annotation as JMS;

/**
 */
class MultimediaCreatedEvent implements DomainEventInterface
{
    /**
     * @var MultimediaId
     *
     * @JMS\Type("Ergonode\Multimedia\Domain\Entity\MultimediaId")
     */
    private $id;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @var string
     *
     * @JMS\Type("string")
     */
    private $extension;

    /**
     * @var string|null
     *
     * @JMS\Type("string")
     */
    private $mime;

    /**
     * The file size in bytes.
     *
     * @var int
     *
     * @JMS\Type("int")
     */
    private $size;

    /**
     * @var Hash
     *
     * @JMS\Type("Ergonode\Multimedia\Domain\ValueObject\Hash")
     */
    private $hash;

    /**
     * @param MultimediaId $id
     * @param string       $name
     * @param string       $extension
     * @param int          $size      The file size in bytes.
     * @param Hash         $hash
     * @param string|null  $mime
     */
    public function __construct(
        MultimediaId $id,
        string $name,
        string $extension,
        int $size,
        Hash $hash,
        ?string $mime = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->extension = $extension;
        $this->mime = $mime;
        $this->size = $size;
        $this->hash = $hash;
    }

    /**
     * @return MultimediaId
     */
    public function getAggregateId(): AbstractId
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @return string|null
     */
    public function getMime(): ?string
    {
        return $this->mime;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return Hash
     */
    public function getHash(): Hash
    {
        return $this->hash;
    }
}
