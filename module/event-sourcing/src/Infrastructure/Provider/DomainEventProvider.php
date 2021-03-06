<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\EventSourcing\Infrastructure\Provider;

use Doctrine\DBAL\Connection;
use Symfony\Component\Cache\Adapter\AdapterInterface;

/**
 */
class DomainEventProvider implements DomainEventProviderInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * @param Connection       $connection
     * @param AdapterInterface $cache
     */
    public function __construct(Connection $connection, AdapterInterface $cache)
    {
        $this->connection = $connection;
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \RuntimeException
     */
    public function provideEventId(string $eventClass): string
    {
        $cacheItem = $this->cache->getItem(sha1($eventClass));
        $eventId = $cacheItem->isHit() ? $cacheItem->get() : $this->fetchFromDatabase($eventClass);

        return (string) $eventId;
    }

    /**
     * @param string $eventClass
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    private function fetchFromDatabase(string $eventClass): string
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->from('event_store_event')
            ->select('id')
            ->where('event_class = :class')
            ->setParameter('class', $eventClass);
        $eventId = $queryBuilder->execute()->fetchColumn();

        if (empty($eventId)) {
            throw new \RuntimeException(sprintf(
                'Event class "%s" not found. Check event definition in "event_store_event" table',
                $eventClass
            ));
        }

        return (string) $eventId;
    }
}
