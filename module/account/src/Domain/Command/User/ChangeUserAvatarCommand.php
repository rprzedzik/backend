<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Account\Domain\Command\User;

use Ergonode\Account\Domain\Entity\UserId;
use Ergonode\EventSourcing\Infrastructure\DomainCommandInterface;
use Ergonode\Multimedia\Domain\Entity\MultimediaId;

/**
 */
class ChangeUserAvatarCommand implements DomainCommandInterface
{
    /**
     * @var UserId
     */
    private $id;

    /**
     * @var MultimediaId
     */
    private $avatarId;

    /**
     * @param UserId            $id
     * @param MultimediaId|null $avatarId
     */
    public function __construct(UserId $id, ?MultimediaId $avatarId = null)
    {
        $this->id = $id;
        $this->avatarId = $avatarId;
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @return MultimediaId|null
     */
    public function getAvatarId(): ?MultimediaId
    {
        return $this->avatarId;
    }
}
