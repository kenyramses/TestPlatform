<?php

namespace ApiBundle\Tests\Controller;


use function json_decode;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\Client\Client;

class TestControllerTest extends WebTestCase
{

    /**
     * @return Client
     */
    private function createTestClient()
    {
        return static::createTestClient();
    }

    public function testGetTestsAction()
    {
        $client = $this->createTestClient();
        $client->get('/api/tests');


        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $this->assertTrue($client->getResponse()->headers->contains(
                'Content-Type', 'application/json'
            )
        );
        $contents = json_decode($client->getResponse()->getContent(), true);

        foreach ($contents as $test) {
            $this->assertArrayHasKey('title', $test);
            $this->assertArrayHasKey('description', $test);
            $this->assertArrayHasKey('questions', $test);

            foreach ($test['questions'] as $question) {
                $this->assertArrayHasKey('content', $question);
                $this->assertArrayHasKey('duration', $question);
                $this->assertArrayHasKey('question_type', $question);
                $this->assertArrayHasKey('answers', $question);

                foreach ($question['answers'] as $answer) {
                    $this->assertArrayHasKey('answer', $answer);
                    $this->assertArrayHasKey('answer_result', $answer);
                }
            }
        }

    }

    public function testGetTestAction()
    {
        $client = $this->createTestClient();
        $client->get('/api/tests/1');

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->headers->contains(
                'Content-Type', 'application/json'
            )
        );

        $this->assertNotEmpty($client->getResponse()->getContent());

        $test = json_decode($client->getResponse()->getContent(), true);


        $this->assertArrayHasKey('title', $test);
        $this->assertArrayHasKey('description', $test);
        $this->assertArrayHasKey('questions', $test);

        $this->assertEquals('1', $test['id']);
        $this->assertEquals('Technical Test Symfony 3', $test['title']);
        $this->assertEquals('This is a simple Symfony Technical Test for Php Symfony Lovers', $test['description']);
        $this->assertGreaterThanOrEqual(1, $test['questions']);

        foreach ($test['questions'] as $question) {
            $this->assertArrayHasKey('content', $question);
            $this->assertArrayHasKey('duration', $question);
            $this->assertArrayHasKey('question_type', $question);
            $this->assertArrayHasKey('answers', $question);

            foreach ($question['answers'] as $answer) {
                $this->assertArrayHasKey('answer', $answer);
                $this->assertArrayHasKey('answer_result', $answer);
            }
        }

    }

    public function testGetNotExistTestAction()
    {
        $client = $this->createTestClient();
        $client->get('/api/tests/00000');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());

        $this->assertEquals('Test Not Found', $client->getResponse()->getContent());

    }

    public function testPostTestAction()
    {
        $client = $this->createTestClient();
        $client->post('/api/tests',
            [
                "title" => "Test php7 Symfony 3.3",
                "description" => "This is a php 7 and Symfony 3.3 technical Test",
                "questions" => [
                    [
                        "content" => "What is the latest Php stable version ?",
                        "duration" => "30",
                        "question_type" => "multiple",
                        "answers" => [
                            [
                                "answer" => " 7.1",
                                "answer_result" => "true"
                            ],
                            [
                                "answer" => " 8.0",
                                "answer_result" => "false"
                            ],
                            [
                                "answer" => " 5.6",
                                "answer_result" => "false"
                            ],
                            [
                                "answer" => " 2.8",
                                "answer_result" => "false"
                            ]
                        ]
                    ],
                    [
                        "content" => "What is the latest Symfony version ?",
                        "question_type" => "unique",
                        "answers" => [
                            [
                                "answer" => " 4.9",
                                "answer_result" => "false"
                            ],
                            [
                                "answer" => " 3.3",
                                "answer_result" => "true"
                            ],
                            [
                                "answer" => " 5.6",
                                "answer_result" => "false"
                            ],
                            [
                                "answer" => " 2.8",
                                "answer_result" => "false"
                            ]
                        ]
                    ]
                ]
            ]
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertGreaterThan(0, $content['id']);
        $this->assertEquals('Test php7 Symfony 3.3', $content['title']);
        $this->assertEquals('This is a php 7 and Symfony 3.3 technical Test', $content['description']);

        $this->assertEquals(2, $content['questions']);

        foreach ($content['questions'] as $question) {
            $this->assertArrayHasKey('content', $question);
            $this->assertArrayHasKey('duration', $question);
            $this->assertArrayHasKey('question_type', $question);
            $this->assertArrayHasKey('answers', $question);

            foreach ($question['answers'] as $answer) {
                $this->assertArrayHasKey('answer', $answer);
                $this->assertArrayHasKey('answer_result', $answer);
            }
        }
    }

    public function testBadPostTestAction()
    {
        $client = $this->createTestClient();
        $client->post('/api/tests',
            [
                "titre" => "Test php7 Symfony 3.3",
                "description" => "This is a php 7 and Symfony 3.3 technical Test",
                "questions" => [
                    [
                        "content" => "What is the latest Php stable version ?",
                        "duration_bad" => "30",
                        "question_type" => "multiple",
                        "response" => [
                            [
                                "answer" => " 7.1",
                                "result" => "true"
                            ],
                            [
                                "answer" => " 8.0",
                                "answer_result" => "false"
                            ],
                            [
                                "toto" => " 5.6",
                                "answer_result" => "false"
                            ],
                            [
                                "answer" => " 2.8",
                                "answer_result" => "false"
                            ]
                        ]
                    ],
                    [
                        "content" => "What is the latest Symfony version ?",
                        "question_type" => "unique",
                        "answers" => [
                            [
                                "answer" => " 4.9",
                                "answer_result" => "false"
                            ],
                            [
                                "answer" => " 3.3",
                                "answer_result" => "true"
                            ],
                            [
                                "answer" => " 5.6",
                                "answer_result" => "false"
                            ],
                            [
                                "answer" => " 2.8",
                                "answer_result" => "false"
                            ]
                        ]
                    ]
                ]
            ]
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());

    }

    public function testPutTestAction()
    {
        $client = $this->createTestClient();
        $client->put('/api/tests/19',
            [
                "titre" => "Test php7 Symfony 2.8",
                "description" => "This is a php 7 and Symfony 2.8 technical Test",
                "questions" => [
                    [
                        "content" => "What is the latest Php stable version ?",
                        "duration_bad" => "30",
                        "question_type" => "multiple",
                        "response" => [
                            [
                                "answer" => " 7.1",
                                "result" => "true"
                            ],
                            [
                                "answer" => " 8.0",
                                "answer_result" => "false"
                            ],
                            [
                                "toto" => " 9.6",
                                "answer_result" => "false"
                            ]
                        ]
                    ],
                    [
                        "content" => "What is the latest Symfony version ?",
                        "question_type" => "multiple",
                        "answers" => [
                            [
                                "answer" => " 4.9",
                                "answer_result" => "false"
                            ],
                            [
                                "answer" => " 3.3",
                                "answer_result" => "true"
                            ],
                            [
                                "answer" => " 5.6",
                                "answer_result" => "false"
                            ],
                            [
                                "answer" => " 2.8",
                                "answer_result" => "false"
                            ]
                        ]
                    ]
                ]
            ]
        );

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $client->delete('/api/tests');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function testDeleteUnaivailableTechnicalTest()
    {
        $client = $this->createTestClient();
        $client->delete('/api/tests/111111');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());

    }






}