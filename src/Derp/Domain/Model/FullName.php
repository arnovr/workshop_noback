<?php

namespace Derp\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable()
 */
class FullName
{
    /**
     * @ORM\Column(type="string")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private $lastName;

    private function __construct()
    {
    }

    public static function fromParts($firstName, $lastName)
    {
        $patient = new static();
        $patient->firstName = $firstName;
        $patient->lastName = $lastName;

        return $patient;
    }

    /**
     * compromise
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * compromise
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}
