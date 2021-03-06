<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Condition\Infrastructure\Condition\Configuration;

use Ergonode\Attribute\Domain\Entity\Attribute\NumericAttribute;
use Ergonode\Attribute\Domain\Query\AttributeQueryInterface;
use Ergonode\Condition\Domain\Condition\NumericAttributeValueCondition;
use Ergonode\Condition\Infrastructure\Condition\ConditionConfigurationStrategyInterface;
use Ergonode\Core\Domain\ValueObject\Language;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 */
class NumericAttributeValueConditionConditionConfigurationStrategy implements ConditionConfigurationStrategyInterface
{
    /**
     * @var AttributeQueryInterface
     */
    private $query;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param AttributeQueryInterface $query
     * @param TranslatorInterface     $translator
     */
    public function __construct(AttributeQueryInterface $query, TranslatorInterface $translator)
    {
        $this->query = $query;
        $this->translator = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public function supports(string $type): bool
    {
        return NumericAttributeValueCondition::TYPE === $type;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfiguration(Language $language): array
    {
        $codes = $this->query->getDictionary([NumericAttribute::TYPE]);

        return [
            'type' => NumericAttributeValueCondition::TYPE,
            'name' => $this
                ->translator
                ->trans(NumericAttributeValueCondition::TYPE, [], 'condition', $language->getCode()),
            'phrase' => $this
                ->translator
                ->trans(NumericAttributeValueCondition::PHRASE, [], 'condition', $language->getCode()),
            'parameters' => [
                [
                    'name' => 'attribute',
                    'type' => 'SELECT',
                    'options' => $codes,
                ],
                [
                    'name' => 'operator',
                    'type' => 'SELECT',
                    'options' => [
                        '=' => '=',
                        '<>' => '<>',
                        '>' => '>',
                        '<' => '<',
                        '>=' => '>=',
                        '<=' => '<=',
                    ],
                ],
                [
                    'name' => 'value',
                    'type' => 'TEXT',
                ],
            ],
        ];
    }
}
