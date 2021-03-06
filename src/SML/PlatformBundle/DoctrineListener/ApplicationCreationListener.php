<?php
/**
 * Created by PhpStorm.
 * User: gidel
 * Date: 04/05/18
 * Time: 18:06
 */

namespace SML\PlatformBundle\DoctrineListener;


use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use SML\PlatformBundle\Email\ApplicationMailer;
use SML\PlatformBundle\Entity\Application;

class ApplicationCreationListener
{
    /**
     * @var ApplicationMailer
     */
    private $applicationMailer;

    public function __construct(ApplicationMailer $applicationMailer)
    {
        $this->applicationMailer = $applicationMailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // On ne veut envoyer un email que pour les entités Application
        if (!$entity instanceof Application) {
            return;
        }

        $this->applicationMailer->sendNewNotification($entity);
    }
}
