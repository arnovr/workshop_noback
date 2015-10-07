<?php

namespace Derp\Application;

use Derp\Domain\Model\BirthDate;
use Derp\Domain\Model\FullName;
use Derp\Domain\Model\Patient;
use Derp\Domain\Model\PatientId;
use Derp\Domain\Model\PatientRepository;
use Derp\Domain\Model\PersonalInformation;
use Derp\Domain\Model\Sex;
use Doctrine\Common\Persistence\ManagerRegistry;

class RegisterWalkInHandler
{
    /**
     * @var PatientRepository
     */
    private $patientRepository;

    /**
     * RegisterWalkInHandler constructor.
     */
    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function __invoke(RegisterWalkIn $registerWalkIn)
    {
        $patient = Patient::walkIn(
            PersonalInformation::fromDetails(
                FullName::fromParts(
                    $registerWalkIn->firstName,
                    $registerWalkIn->lastName
                ),
                BirthDate::fromYearMonthDayFormat($registerWalkIn->dateOfBirth),
                new Sex($registerWalkIn->sex),
                $registerWalkIn->patientId
            ),
            $registerWalkIn->indication,
            $registerWalkIn->patientId
        );

        $this->patientRepository->add($patient);
    }
}