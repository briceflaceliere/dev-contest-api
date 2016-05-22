<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 17/05/16
 * Time: 13:18
 */

namespace DevContest\DevContestApiBundle\Tests;


class TestPrinter extends \PHPUnit_TextUI_ResultPrinter
{
    /**
     * @param \PHPUnit_Framework_TestFailure $defect
     * @param int                            $count
     */
    protected function printDefectHeader(\PHPUnit_Framework_TestFailure $defect, $count)
    {
        if ($defect->failedTest() instanceof WebTestCase) {
            $user = $defect->failedTest()->getConnectedUser();
            $this->write(
                sprintf(
                    "\n%d) %s [User : %s]\n",
                    $count,
                    $defect->getTestName(),
                    $user ? $user->getUsername() : 'Disconnected'
                )
            );
        } else {
            return parent::printDefectHeader($defect, $count);
        }
    }
} 