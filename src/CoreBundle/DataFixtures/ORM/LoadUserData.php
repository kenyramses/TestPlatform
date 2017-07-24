<?php

namespace CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CoreBundle\Entity\Test;
use CoreBundle\Entity\Question;
use CoreBundle\Entity\Answer;
use const false;
use const true;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $answer1 = new Answer();
        $answer1->setAnswer('3.3');
        $answer1->setAnswerResult(true);

        $answer2 = new Answer();
        $answer2->setAnswer('5.3');
        $answer2->setAnswerResult(false);

        $answer3 = new Answer();
        $answer3->setAnswer('1.3');
        $answer3->setAnswerResult(false);

        $question1 = new Question();
        $question1->setContent('what is the current version of Symfony ?');
        $question1->setDuration(30);
        $question1->setQuestionType('multiple');

        $question1->addAnswer($answer1);
        $question1->addAnswer($answer2);
        $question1->addAnswer($answer3);
//
//        $answer4 = new Answer();
//        $answer4->setAnswer('a programming language');
//        $answer4->setAnswerResult(true);
//
//        $answer5 = new Answer();
//        $answer5->setAnswer('a javascript framework');
//        $answer5->setAnswerResult(false);
//
//        $answer6 = new Answer();
//        $answer6->setAnswer('a templatong engine');
//        $answer6->setAnswerResult(false);
//
//        $question2 = new Question();
//        $question2->setContent('what is Php ?');
//        $question2->setDuration(60);
//        $question2->setQuestionType('unique');
//        $question2->addAnswer($answer4);
//        $question2->addAnswer($answer5);
//        $question2->addAnswer($answer6);

        $test = new Test();
        $test->setTitle('Symfony 3.3 && Php 7 Technical Test ');
        $test->setDescription('This is a simple technical test for Php and Symfony lover');

        $test->addQuestion($question1);
        //$test->addQuestion($question2);

        $manager->persist($test);
        $manager->flush();



    }

}