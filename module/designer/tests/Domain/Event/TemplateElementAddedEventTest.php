<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Designer\Tests\Domain\Event;

use Ergonode\Designer\Domain\Entity\TemplateElement;
use Ergonode\Designer\Domain\Entity\TemplateId;
use Ergonode\Designer\Domain\Event\TemplateElementAddedEvent;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 */
class TemplateElementAddedEventTest extends TestCase
{
    /**
     */
    public function testEventCreation(): void
    {
        /** @var TemplateId | MockObject $id */
        $id = $this->createMock(TemplateId::class);

        /** @var TemplateElement | MockObject $element */
        $element = $this->createMock(TemplateElement::class);

        $event = new TemplateElementAddedEvent($id, $element);

        $this->assertSame($id, $event->getAggregateId());
        $this->assertSame($element, $event->getElement());
    }
}
