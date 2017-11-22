<?php

namespace AppBundle\Service\Config;

use \Doctrine\ORM\EntityManagerInterface;

/**
 * Class ConfigFetcher
 */
class ConfigFetcher
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ConfigFetcher constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->em->getRepository('AppBundle:Config')->findOneBy(["enabled" => true]);
    }
}