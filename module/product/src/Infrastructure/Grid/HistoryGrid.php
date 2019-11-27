<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Product\Infrastructure\Grid;

use Ergonode\Core\Domain\ValueObject\Language;
use Ergonode\Grid\AbstractGrid;
use Ergonode\Grid\Column\IntegerColumn;
use Ergonode\Grid\Column\TextColumn;
use Ergonode\Grid\Filter\TextFilter;
use Ergonode\Grid\GridConfigurationInterface;
use Ergonode\Product\Infrastructure\Grid\Column\HistoryColumn;

/**
 */
class HistoryGrid extends AbstractGrid
{
    /**
     * @param GridConfigurationInterface $configuration
     * @param Language                   $language
     */
    public function init(GridConfigurationInterface $configuration, Language $language): void
    {
        $filters = $configuration->getFilters();

        $id = new IntegerColumn('id', 'Id');
        $id->setVisible(false);
        $this->addColumn('id', $id);
        $this->addColumn('recorded_at', new TextColumn('recorded_at', 'Time', new TextFilter($filters->get('recorded_at'))));
        $column = new HistoryColumn('event', 'payload', 'Message', $language);
        $this->addColumn('event', $column);
        $this->setConfiguration(AbstractGrid::PARAMETER_ALLOW_COLUMN_RESIZE, true);
        $this->orderBy('recorded_at', 'DESC');
    }
}