<?php

namespace Derp\Infrastructure\Persistence;

use Derp\Domain\Model\Patient;
use Derp\Domain\Model\PatientId;
use Derp\Domain\Model\PatientRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Rhumsaa\Uuid\Uuid;

class DoctrinePatientRepository implements PatientRepository
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * DoctrinePatientRepository constructor.
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param Patient $patient
     */
    public function add(Patient $patient)
    {
        $em = $this->doctrine->getManager();
        $em->persist($patient);
    }

    public function nextIdentity()
    {
        return PatientId::fromString(Uuid::uuid4());
    }
}