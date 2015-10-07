<?php

namespace Derp\Domain\Model;

use Assert\Assertion;

class PatientId
{
    private $id;

    private function __construct()
    {
    }

    public static function fromString($uuid)
    {
        Assertion::uuid($uuid);
        $patientId = new static();
        $patientId->id = $uuid;

        return $patientId;
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}
