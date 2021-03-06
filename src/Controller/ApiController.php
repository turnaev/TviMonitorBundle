<?php

/**
 * This file is part of the `tvi/monitor-bundle` project.
 *
 * (c) https://github.com/turnaev/monitor-bundle/graphs/contributors
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Tvi\MonitorBundle\Controller;

/**
 * @author Vladimir Turnaev <turnaev@gmail.com>
 */
class ApiController
{
    use TraitCommon;

    use TraitApiCommon;
    use TraitApiCheck;
    use TraitApiInfoCheck;
    use TraitApiInfoGroup;
    use TraitApiInfoTag;
}
