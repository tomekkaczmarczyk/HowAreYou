<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Answers;
use AppBundle\Entity\Questions;
use AppBundle\Entity\Test;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\TestType;
use AppBundle\Form\QuestionType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {

    }


    /**
     * @Route("/usertest", name="usertest")
     * @Template()
     */
    public function userTestAction()
    {

    }


    /**
     * @Route("/addtest")
     * @Template()
     */
    public function newTestAction(Request $request)
    {
        $test = new Test();

        $form = $this->createForm(new TestType(), $test);

        $form->add('Dodaj Test', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($test);
            $em->flush();

            return $this->redirectToRoute('app_default_showall', ['id' => $test->getId(), 'test' => $test]);
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/test/{id}/modify")
     * @Template()
     */
    public function modifyAction(Request $request, $id)
    {
        $test = $this->getDoctrine()->getRepository("AppBundle:Test")->find($id);


        $testForm = $this->addQuestionFormAction($request, $test);


        if ($testForm->isValid()) {
            $this->redirectToRoute('app_default_modify', ['id' => $test->getId(), 'test' => $testForm->createView()]);

        }
        return ['testForm' => $testForm->createView()];
    }


    public function addQuestionFormAction(Request $request, Test $test)
    {
        $question = new Questions();
        $questionForm = $this->createForm(new QuestionType(), $question);
        $questionForm->add('Dodaj pytanie', 'submit');
        $questionForm->handleRequest($request);

        if ($questionForm->isValid()) {
            $question->setTest($test);
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();
        }

        return $questionForm;
    }

    /**
     * @Route("/test/{id}")
     * @Template()
     */
    public function showTestAction(Request $request, $id)
    {
        $test = $this->getDoctrine()->getRepository("AppBundle:Test")->find($id);
        $questions = $this->getDoctrine()->getRepository("AppBundle:Questions")->findByTest($id);

        if (!$test) {
            throw $this->createNotFoundException("Nie udało się znaleźć testu");
        }

        return ['test' => $test, 'questions' => $questions
        ];
    }

    /**
     * @Route("/tests")
     *
     * @Template()
     */
    public function showTestsAction()
    {
        $tests = $this->getDoctrine()->getRepository("AppBundle:Test")->findBy(array(), array('name' => 'ASC'));;

        if (!$tests) {
            throw $this->createNotFoundException("Nie znaleziono testu w bazie danych");
        }

        return ['tests' => $tests];
    }

    /**
     * @Route("/usersite")
     * @Template()
     */
    public function userSiteAction()
    {
        $tests = $this->getDoctrine()->getRepository("AppBundle:Test")->findBy(array(), array('name' => 'ASC'));;

        if (!$tests) {
            throw $this->createNotFoundException("Nie znaleziono testu w bazie danych");
        }

        return ['tests' => $tests];
    }

    /**
     * @Route("/form/{id}")
     * @Template()
     */
    public function formAction(Request $request, $id)
    {
        if ($request->getMethod() === 'GET') {
            $test = $this->getDoctrine()->getRepository("AppBundle:Test")->find($id);
            $questions = $test->getQuestions();

            if (!$test) {
                throw $this->createNotFoundException("Nie udało się znaleźć testu");
            }

            return ['test' => $test, 'questions' => $questions
            ];
        } else {
            $answers = $request->request->get('answers');

            $em = $this->getDoctrine()->getManager();

            foreach ($answers as $id => $answer) {
                $question = $this->getDoctrine()->getRepository('AppBundle:Questions')->find($id);

                $a = new Answers($question, $this->getUser());
                $a->setDate(new \DateTime());
                $a->setPoints($answer);

                $em->persist($a);
            }

            $em->flush();

            return $this->redirectToRoute('app_default_usersite');
        }



    }


}
