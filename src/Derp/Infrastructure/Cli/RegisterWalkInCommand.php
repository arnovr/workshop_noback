<?php

namespace Derp\Infrastructure\Cli;

use Derp\Application\RegisterWalkIn;
use Derp\Bundle\ERBundle\Form\RegisterWalkInType;
use Matthias\SymfonyConsoleForm\Console\Command\FormBasedCommand;
use Matthias\SymfonyConsoleForm\Console\Command\FormBasedCommandCapabilities;
use Matthias\SymfonyConsoleForm\Console\Helper\FormHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterWalkInCommand extends ContainerAwareCommand implements FormBasedCommand
{
    use FormBasedCommandCapabilities;

    /**
     * @var RegisterWalkIn
     */
    public $command;

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName('register:walk-in');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $repository = $this->getContainer()->get('infrastructure.patient_repository');
        /** @var FormHelper $formHelper */
        $formHelper = $this->getHelper('form');
        $command = $formHelper->interactUsingForm(
            new RegisterWalkInType(),
            $input,
            $output
        );
        $command->patientId = $repository->nextIdentity();

        $this->getContainer()->get('command_bus')
        ->handle($command);
    }

    public function formType()
    {
        return new RegisterWalkInType();
    }

    public function setFormData($data)
    {
        $this->command = $data;
    }
}