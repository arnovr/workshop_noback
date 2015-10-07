<?php

namespace Derp\Bundle\ERBundle\Controller;

use Derp\Bundle\ERBundle\Form\RegisterWalkInType;
use Derp\Domain\Model\Patient;
use Rhumsaa\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/patients")
 */
class PatientController extends Controller
{
    /**
     * @Route("/", name="patient_list")
     * @Template()
     */
    public function listAction()
    {
        $patients = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Patient::class)
            ->findAll();

        return array(
            'patients' => $patients
        );
    }

    /**
     * @Route("/find-by-last-name/", name="patient_find_by_last_name")
     * @Template("@DerpERBundle/Resources/views/Patient/list.html.twig")
     */
    public function findByLastName(Request $request)
    {
        $patients = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Patient::class)
            ->findBy(
                ['personalInformation.name.lastName' => $request->query->get('lastName')]
            );

        return array(
            'patients' => $patients
        );
    }

    /**
     * @Route("/registerWalkIn/", name="register_walk_in")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function registerWalkInAction(Request $request)
    {
        $form = $this->createForm(new RegisterWalkInType());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $repository = $this->get('infrastructure.patient_repository');
            $registerWalkIn = $form->getData();
            $registerWalkIn->patientId = $repository->nextIdentity();

            $this->get('command_bus')->handle($registerWalkIn);

            return $this->redirect($this->generateUrl('patient_details', ['id' => $registerWalkIn->patientId]));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}/", name="patient_details")
     * @Method("GET")
     * @Template()
     */
    public function detailsAction($id)
    {
        $patient = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(Patient::class)
            ->find($id);

        if ($patient === null) {
            throw $this->createNotFoundException();
        }

        return array(
            'patient' => $patient
        );
    }
}
