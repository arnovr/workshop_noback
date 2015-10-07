<?php

namespace Derp\Domain\Model;

use Assert\Assertion;
use Doctrine\ORM\Mapping as ORM;
use SimpleBus\Message\Recorder\ContainsRecordedMessages;
use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 */
class Patient implements ContainsRecordedMessages
{
    use PrivateMessageRecorderCapabilities;

    /**
     * @ORM\Id()
     * @ORM\Column(type="patient_id")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $indication;

    /**
     * @ORM\Column(type="boolean")
     */
    private $arrived;

    /**
     * @ORM\Embedded(class="PersonalInformation", columnPrefix=false)
     */
    private $personalInformation;

    private function __construct(PersonalInformation $personalInformation, $indication, $arrived, PatientId $id)
    {
        Assertion::string($indication);
        Assertion::notEmpty($indication);
        $this->indication = $indication;

        Assertion::boolean($arrived);
        $this->arrived = $arrived;

        $this->personalInformation = $personalInformation;

        $this->id = $id;
    }

    public static function walkIn(PersonalInformation $personalInformation, $indication, PatientId $id)
    {
        $patient = new Patient($personalInformation, $indication, true, $id);
        $patient->record(new WalkInRegistered($personalInformation, $indication));
        return $patient;
    }

    public static function announce(PersonalInformation $personalInformation, $indication, PatientId $id)
    {
        return new Patient($personalInformation, $indication, false, $id);
    }

    public function registerArrival()
    {
        \Assert\that($this->arrived)->false('The patient already arrived');

        $this->arrived = true;
    }

    public function getId()
    {
        return PatientId::fromString($this->id);
    }

    public function getIndication()
    {
        return $this->indication;
    }

    public function hasArrived()
    {
        return $this->arrived;
    }

    public function getPersonalInformation()
    {
        return $this->personalInformation;
    }

    /**
     * compromise
     */
    public function setIndication($indication)
    {
        $this->indication = $indication;
    }

    /**
     * compromise
     */
    public function setArrived($arrived)
    {
        $this->arrived = $arrived;
    }

    /**
     * compromise
     */
    public function setPersonalInformation(PersonalInformation $personalInformation)
    {
        $this->personalInformation = $personalInformation;
    }
}
