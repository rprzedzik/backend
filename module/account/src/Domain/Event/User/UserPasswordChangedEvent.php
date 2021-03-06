<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Account\Domain\Event\User;

use Ergonode\Account\Domain\Entity\UserId;
use Ergonode\Account\Domain\ValueObject\Password;
use Ergonode\Core\Domain\Entity\AbstractId;
use Ergonode\EventSourcing\Infrastructure\DomainEventInterface;
use JMS\Serializer\Annotation as JMS;

/**
 */
class UserPasswordChangedEvent implements DomainEventInterface
{
    /**
     * @var UserId
     *
     * @JMS\Type("Ergonode\Account\Domain\Entity\UserId")
     */
    private $id;

    /**
     * @var Password
     *
     * @JMS\Type("Ergonode\Account\Domain\ValueObject\Password")
     */
    private $password;

    /**
     * @param UserId   $id
     * @param Password $password
     */
    public function __construct(UserId $id, Password $password)
    {
        $this->id = $id;
        $this->password = $password;
    }

    /**
     * @return UserId
     */
    public function getAggregateId(): AbstractId
    {
        return $this->id;
    }

    /**
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }
}
