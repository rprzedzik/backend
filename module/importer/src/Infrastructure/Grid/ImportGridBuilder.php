<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Importer\Infrastructure\Grid;

use Ergonode\Core\Domain\ValueObject\Language;
use Ergonode\Grid\Column\DateColumn;
use Ergonode\Grid\Column\IntegerColumn;
use Ergonode\Grid\Filter\DateFilter;
use Ergonode\Grid\Filter\TextFilter;
use Ergonode\Grid\GridConfigurationInterface;
use Ergonode\Grid\Column\SelectColumn;
use Ergonode\Grid\Filter\MultiSelectFilter;
use Ergonode\Grid\Filter\Option\LabelFilterOption;
use Ergonode\Importer\Infrastructure\Dictionary\ImportStatusDictionary;
use Ergonode\Grid\GridInterface;
use Ergonode\Grid\GridBuilderInterface;
use Ergonode\Grid\Grid;
use Ergonode\Grid\Column\IdColumn;
use Ergonode\Grid\Action\GetAction;

class ImportGridBuilder implements GridBuilderInterface
{
    private ImportStatusDictionary $dictionary;

    public function __construct(ImportStatusDictionary $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    public function build(GridConfigurationInterface $configuration, Language $language): GridInterface
    {
        $status = $this->getStatus($language);

        $grid = new Grid();

        $grid
            ->addColumn('id', new IdColumn('id'))
            ->addColumn('created_at', new DateColumn('created_at', 'Created at', new DateFilter()))
            ->addColumn('started_at', new DateColumn('started_at', 'Started on', new DateFilter()))
            ->addColumn('ended_at', new DateColumn('ended_at', 'Ended at', new DateFilter()))
            ->addColumn('records', new IntegerColumn('records', 'Records', new TextFilter()))
            ->addColumn('status', new SelectColumn('status', 'Status', new MultiSelectFilter($status)))
            ->addColumn('errors', new IntegerColumn('errors', 'Errors', new TextFilter()))
            ->addAction('ergonode_import_read', new GetAction(
                'ergonode_import_read',
                'IMPORT_READ',
                [
                    'language' => $language->getCode(),
                    'source' => '{source_id}',
                    'import' => '{id}',
                ]
            ))
            ->orderBy('created_at', 'DESC');

        return $grid;
    }

    private function getStatus(Language $language): array
    {
        $status = [];
        foreach ($this->dictionary->getDictionary($language) as $key => $value) {
            $status[] = new LabelFilterOption($key, $value);
        }

        return $status;
    }
}
