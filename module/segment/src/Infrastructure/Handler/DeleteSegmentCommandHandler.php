<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Segment\Infrastructure\Handler;

use Ergonode\Core\Infrastructure\Exception\ExistingRelationshipsException;
use Ergonode\Core\Infrastructure\Resolver\RelationshipsResolverInterface;
use Ergonode\Segment\Domain\Command\DeleteSegmentCommand;
use Ergonode\Segment\Domain\Entity\Segment;
use Ergonode\Segment\Domain\Repository\SegmentRepositoryInterface;
use Webmozart\Assert\Assert;

/**
 */
class DeleteSegmentCommandHandler
{
    /**
     * @var SegmentRepositoryInterface
     */
    private $repository;

    /**
     * @var RelationshipsResolverInterface
     */
    private $relationshipsResolver;

    /**
     * @param SegmentRepositoryInterface     $repository
     * @param RelationshipsResolverInterface $relationshipsResolver
     */
    public function __construct(
        SegmentRepositoryInterface $repository,
        RelationshipsResolverInterface $relationshipsResolver
    ) {
        $this->repository = $repository;
        $this->relationshipsResolver = $relationshipsResolver;
    }

    /**
     * @param DeleteSegmentCommand $command
     *
     * @throws ExistingRelationshipsException
     */
    public function __invoke(DeleteSegmentCommand $command)
    {
        $segment = $this->repository->load($command->getId());
        Assert::isInstanceOf($segment, Segment::class, sprintf('Can\'t find segment with ID "%s"', $command->getId()));

        $relationships = $this->relationshipsResolver->resolve($command->getId());
        if (!$relationships->isEmpty()) {
            throw new ExistingRelationshipsException($command->getId());
        }

        $this->repository->delete($segment);
    }
}
