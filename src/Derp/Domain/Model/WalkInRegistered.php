<?php

namespace Derp\Domain\Model;

class WalkInRegistered
{
    /**
     * @var PersonalInformation
     */
    private $personalInformation;

    /**
     * @var string
     */
    private $indication;

    /**
     * WalkInRegistered constructor.
     */
    public function __construct(PersonalInformation $personalInformation, $indication)
    {
        $this->personalInformation = $personalInformation;
        $this->indication = $indication;
    }

    /**
     * @return string
     */
    public function indication()
    {
        return $this->indication;
    }
}