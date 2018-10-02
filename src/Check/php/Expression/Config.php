<?php

/**
 * This file is part of the `tvi/monitor-bundle` project.
 *
 * (c) https://github.com/turnaev/monitor-bundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Tvi\MonitorBundle\Check\php\Expression;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Tvi\MonitorBundle\Check\CheckConfigAbstract;

/**
 * @author Vladimir Turnaev <turnaev@gmail.com>
 */
class Config extends CheckConfigAbstract
{
    public const DESCR =
<<<'TXT'
expression description
TXT;

    public const PATH = __DIR__;

    public const GROUP = 'php';
    public const CHECK_NAME = 'expression';

    /**
     * @param NodeDefinition|ArrayNodeDefinition $node
     *
     * @return NodeDefinition|ArrayNodeDefinition
     */
    protected function _check(NodeDefinition $node): NodeDefinition
    {
        $node = $node
            ->children()
                ->arrayNode('check')
                    ->addDefaultsIfNotSet()
                    ->validate()
                        ->ifTrue(static function ($value) {
                            return !$value['warningExpression'] && !$value['criticalExpression'];
                        })
                        ->thenInvalid('A warningExpression or a criticalExpression must be set.')
                    ->end()
                    ->children()
                      ->scalarNode('criticalExpression')->defaultNull()->example('ini(\'apc.stat\') == 0')->end()
                      ->scalarNode('criticalMessage')->defaultNull()->end()
                      ->scalarNode('warningExpression')->defaultNull()->example('ini(\'short_open_tag\') == 1')->end()
                      ->scalarNode('warningMessage')->defaultNull()->end()
                    ->end()
                ->end()
            ->end();

        $this->_group($node);
        $this->_tags($node);
        $this->_label($node);

        return $node;
    }
}