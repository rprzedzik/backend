<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Attribute\Domain\Command;

use Ergonode\Attribute\Domain\Entity\AttributeId;
use Ergonode\EventSourcing\Infrastructure\DomainCommandInterface;

/**
 */
class DeleteAttributeCommand implements DomainCommandInterface
{
    /**
     * @var AttributeId
     */
    private $id;

    /**
     * @param AttributeId $id
     */
    public function __construct(AttributeId $id)
    {
        $this->id = $id;
    }

    /**
     * @return AttributeId
     */
    public function getId(): AttributeId
    {
        return $this->id;
    }
}
