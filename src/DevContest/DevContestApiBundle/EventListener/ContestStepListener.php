<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 31/05/16
 * Time: 13:46
 */

namespace DevContest\DevContestApiBundle\EventListener;


use DevContest\DevContestApiBundle\Entity\ContestStep;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ContestStepListener {

    public function preRemove(LifecycleEventArgs $event)
    {
        $step = $event->getEntity();
        if (!$step instanceof ContestStep) {
            return;
        }

        if ($nextStep = $step->getNextContestStep()) {
            $nextStep->setPreviousContestStep($step->getPreviousContestStep());
            $event->getEntityManager()->persist($nextStep);
        }
    }

} 