<?php

/**
 * This file is part of the `tvi/monitor-bundle` project.
 *
 * (c) https://github.com/turnaev/monitor-bundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Tvi\MonitorBundle\Check\http\HttpService;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Tvi\MonitorBundle\Check\CheckPluginAbstract;

/**
 * @author Vladimir Turnaev <turnaev@gmail.com>
 */
class Plugin extends CheckPluginAbstract
{
    const DESCR =
<<<'TXT'
http_service description
TXT;

    const PATH = __DIR__;

    const GROUP = 'http';
    const CHECK_NAME = 'core:http_service';

    protected function _check(ArrayNodeDefinition $node): ArrayNodeDefinition
    {
        $node = $node
            ->children()
                ->arrayNode('check')
                    ->children()
                        ->scalarNode('host')->cannotBeEmpty()->end()
                        ->integerNode('port')->defaultValue(80)->end()
                        ->scalarNode('path')->defaultValue('/')->end()
                        ->scalarNode('statusCode')->defaultNull()->end()
                        ->scalarNode('content')->defaultNull()->end()
                    ->end()
                ->end()
            ->end();

        $this->_addition($node);

        return $node;
    }
}
