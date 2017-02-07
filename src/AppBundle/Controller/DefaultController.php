<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Person;
use AppBundle\Form\PersonType;
use AppBundle\Entity\Employee;
use AppBundle\Form\EmployeeType;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        return $this->render('AppBundle:General:index.html.twig', array(
        ));
    }

    /**
     * @Route("/add/person/", name="add_person")
     */
    public function addPersonAction(Request $request) {

        // On crée un objet Animal
        $person = new Person();

        // On crée le FormBuilder grâce au service form factory
        //$form = $this->get('form.factory')->create(new AnimalType(), $animal);
        $form = $this->createForm(new PersonType(), $person);

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);

        // On vérifie que les valeurs entrées sont correctes
        // (Nous verrons la validation des objets en détail dans le prochain chapitre)
        if ($form->isValid()) {
            // On l'enregistre notre objet $advert dans la base de données, par exemple
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Person Recorded');

            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirect($this->generateUrl('view_person', array('id' => $person->getId())));
        }

        // À ce stade, le formulaire n'est pas valide car :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau

        return $this->render('AppBundle:General:addPerson.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route(
     * "/view/person/{id}", name="view_person",
     *  requirements = {
     *     "id" = "^\d+$"
     *                }
     * )
     */
    public function viewPersonAction($id) {
        $em = $this->getDoctrine()->getManager();

        // Pour récupérer une seule annonce, on utilise la méthode find($id)
        $person = $em->getRepository('AppBundle:Person')->find($id);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id n'existe pas, d'où ce if :
        if (null === $person) {
            throw new NotFoundHttpException("The person id " . $id . " doesn't exist");
        }


        return $this->render('AppBundle:General:viewPerson.html.twig', array(
                    'person' => $person
        ));
    }

    /**
     * @Route("/add/employee/", name="add_employee")
     */
    public function addEmployeeAction(Request $request) {

        // On crée un objet Animal
        $employee = new Employee();

        // On crée le FormBuilder grâce au service form factory
        //$form = $this->get('form.factory')->create(new AnimalType(), $animal);
        $form = $this->createForm(new EmployeeType(), $employee);

        // On fait le lien Requête <-> Formulaire
        // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
        $form->handleRequest($request);

        // On vérifie que les valeurs entrées sont correctes
        // (Nous verrons la validation des objets en détail dans le prochain chapitre)
        if ($form->isValid()) {
            // On l'enregistre notre objet $advert dans la base de données, par exemple
            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Employee Recorded');

            // On redirige vers la page de visualisation de l'annonce nouvellement créée
            return $this->redirect($this->generateUrl('view_employee', array('id' => $employee->getId())));
        }

        // À ce stade, le formulaire n'est pas valide car :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau

        return $this->render('AppBundle:General:addEmployee.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route(
     * "/view/employee/{id}", name="view_employee",
     *  requirements = {
     *     "id" = "^\d+$"
     *                }
     * )
     */
    public function viewEmployeeAction($id) {
        $em = $this->getDoctrine()->getManager();

        // Pour récupérer une seule annonce, on utilise la méthode find($id)
        $employee = $em->getRepository('AppBundle:Employee')->find($id);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id n'existe pas, d'où ce if :
        if (null === $employee) {
            throw new NotFoundHttpException("The employee id " . $id . " doesn't exist");
        }


        return $this->render('AppBundle:General:viewEmployee.html.twig', array(
                    'employee' => $employee
        ));
    }

}
