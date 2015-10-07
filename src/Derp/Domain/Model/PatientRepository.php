<?php

namespace Derp\Domain\Model;

interface PatientRepository
{
    public function add(Patient $patient);

    public function nextIdentity();
}