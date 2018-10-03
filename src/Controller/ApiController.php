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

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Tvi\MonitorBundle\Reporter\Api;
use Tvi\MonitorBundle\Reporter\ReporterManager;
use Tvi\MonitorBundle\Runner\RunnerManager;

/**
 * @author Vladimir Turnaev <turnaev@gmail.com>
 */
class ApiController
{
    /**
     * @var RunnerManager
     */
    protected $runnerManager;

    /**
     * @var ReporterManager
     */
    protected $reporterManager;

    public function __construct(RunnerManager $runnerManager, ReporterManager $reporterManager)
    {
        $this->runnerManager = $runnerManager;
        $this->reporterManager = $reporterManager;
    }

    public function testAction(Request $request)
    {
        $check = $request->get('check', []);
        if (\is_string($check)) {
            $check = $check ? [$check] : [];
        }

        $groups = $request->get('group', []);
        if (\is_string($groups)) {
            $groups = $groups ? [$groups] : [];
        }

        $tags = $request->get('tag', []);
        if (\is_string($tags)) {
            $tags = $tags ? [$tags] : [];
        }

        $runner = $this->runnerManager->getRunner($check, $groups, $tags);
        /** @var $reporter Api */
        $reporter = $this->reporterManager->getReporter('api');

        $runner->addReporter($reporter);
        $runner->run();

        return new JsonResponse([
            'statusCode' => $reporter->getStatusCode(),
            'statusName' => $reporter->getStatusName(),

            'successes' => $reporter->getSuccessCount(),
            'warnings' => $reporter->getWarningCount(),
            'failures' => $reporter->getFailureCount(),
            'unknowns' => $reporter->getUnknownCount(),
            'total' => $reporter->getTotalCount(),

            'checks' => $reporter->getCheckResults(),
        ]);

//        v($reporter->getResults());
//        exit;
//        $number = random_int(0, 100);
//
//        return new Response(
//            '<html><body>Lucky number: '.$number.'</body></html>'
//        );
    }
}
