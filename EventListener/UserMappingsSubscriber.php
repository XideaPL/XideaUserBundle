<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\UserBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

/**
 *
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class UserMappingsSubscriber implements EventSubscriber
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata
        );
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $metadata = $eventArgs->getClassMetadata();

        $namingStrategy = $eventArgs
                ->getEntityManager()
                ->getConfiguration()
                ->getNamingStrategy()
        ;
        
        if ($metadata->getName() !== $this->container->getParameter('xidea_user.user.class')) {
            return;
        }
        
        if ($this->container->getParameter('xidea_user.role.enabled') && !$metadata->hasAssociation('rolesCollection')) {
            $metadata->mapManyToMany(array(
                'targetEntity' => 'Xidea\Bundle\UserBundle\Model\AbstractRole',
                'fieldName' => 'roles',
                'joinTable' => array(
                    'name' => 'user_role',
                    'joinColumns' => array(
                        array(
                            'name' => 'user_id',
                            'referencedColumnName' => 'id',
                            'onDelete' => 'CASCADE',
                            'onUpdate' => 'CASCADE'
                        )
                    ),
                    'inverseJoinColumns' => array(
                        array(
                            'name' => 'role_id',
                            'referencedColumnName' => 'id',
                            'onDelete' => 'CASCADE',
                            'onUpdate' => 'CASCADE'
                        )
                    )
                ),
                'cascade' => array('persist')
            ));
        }
    }
}
