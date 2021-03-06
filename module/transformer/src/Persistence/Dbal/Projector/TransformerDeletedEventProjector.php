<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Transformer\Persistence\Dbal\Projector;

use Doctrine\DBAL\Connection;
use Ergonode\Transformer\Domain\Event\TransformerDeletedEvent;

/**
 */
class TransformerDeletedEventProjector
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(TransformerDeletedEvent $event): void
    {
        $this->connection->delete(
            'importer.transformer',
            [
                'id' => $event->getAggregateId()->getValue(),
            ]
        );
    }
}
