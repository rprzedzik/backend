<?php

/**
 * Copyright © Ergonode Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Ergonode\Designer\Infrastructure\Handler;

use Ergonode\Designer\Domain\Command\CreateTemplateCommand;
use Ergonode\Designer\Domain\Factory\TemplateFactory;
use Ergonode\Designer\Domain\Query\TemplateGroupQueryInterface;
use Ergonode\Designer\Domain\Repository\TemplateRepositoryInterface;
use Ergonode\Designer\Application\Event\TemplateCreatedEvent;
use Ergonode\SharedKernel\Domain\Bus\ApplicationEventBusInterface;

class CreateTemplateHandler
{
    private TemplateRepositoryInterface $templateRepository;

    private TemplateFactory $templateFactory;

    private TemplateGroupQueryInterface $templateGroupQuery;

    private ApplicationEventBusInterface $eventBus;

    public function __construct(
        TemplateRepositoryInterface $templateRepository,
        TemplateFactory $templateFactory,
        TemplateGroupQueryInterface $templateGroupQuery,
        ApplicationEventBusInterface $eventBus
    ) {
        $this->templateRepository = $templateRepository;
        $this->templateFactory = $templateFactory;
        $this->templateGroupQuery = $templateGroupQuery;
        $this->eventBus = $eventBus;
    }

    public function __invoke(CreateTemplateCommand $command): void
    {
        $groupId = $this->templateGroupQuery->getDefaultId();

        $template = $this->templateFactory->create(
            $command->getId(),
            $groupId,
            $command->getName(),
            $command->getDefaultLabel(),
            $command->getDefaultImage(),
            $command->getElements()->toArray(),
            $command->getImageId()
        );

        $this->templateRepository->save($template);
        $this->eventBus->dispatch(new TemplateCreatedEvent($template));
    }
}
