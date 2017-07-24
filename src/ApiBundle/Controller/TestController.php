<?php

namespace ApiBundle\Controller;


use CoreBundle\Entity\Test;
use CoreBundle\Form\TestType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View as RestView;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class TestController
 * @package ApiBundle\Controller
 */
class TestController extends FOSRestController
{
    /**
     * @Rest\Get("", name="tests_list", options={ "method_prefix" = false } )
     */
    public function getTestsAction()
    {
        if(!$tests = $this->getDoctrine()->getManager()->getRepository(Test::class)->findAll() ) {
            return $this->testNotFound();
        }

        return $tests;

    }

    /**
     * @Rest\Get("/{test_id}", name="single_test", options = { "method_prefix" = false } )
     * @ParamConverter("test", options = { "mapping" : {"test_id" : "id" } } )
     */
    public function getTestAction(Test $test)
    {
        if (!$test) {

            return $this->testNotFound();

        }

        return $test;
    }

    /**
     * @Rest\Post("", name = "post_test", options = { "method_prefix" = false } )
     */
    public function postTestAction(Request $request)
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);

        $form->submit($request->request->all());

        if($form->isValid() && $form->isSubmitted() ) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($test);
            $em->flush();

            return $test;
        }

        return $form;
    }

    /**
     * @Rest\Put("/{test_id}", name="update_single_test", options = {"method_prefix" = false } )
     * @ParamConverter("test", options = { "mapping" : {"test_id" : "id" } } )
     */
    public function putTestAction(Test $test, Request $request)
    {
        if(!$test) {
            return $this->testNotFound('test not found');
        }

        $form = $this->createForm(TestType::class, $test);

        $form->submit($request->request->all());

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($test);
            $em->flush();

            return $test;
        }

        throw new BadRequestHttpException() ;

    }

    /**
     * @Rest\Delete("/{test_id}", name="delete_signle_test", options = { "method_prefix" = false })
     * @ParamConverter("test", options={ "mapping" : {"test_id" : "id" } } )
     */
    public function deleteTestAction(Test $test)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($test);
        $em->flush();

        return RestView::create(["message" => "test removed successfully"], Response::HTTP_OK);

    }

    private function testNotFound($message = "test not found")
    {
        return RestView::create(["message"=>$message], Response::HTTP_NOT_FOUND);
    }

}