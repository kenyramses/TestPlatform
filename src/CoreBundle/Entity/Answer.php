<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use CoreBundle\Entity\Question;

/**
 * Answer
 *
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\AnswerRepository")
 */
class Answer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="text")
     */
    private $answer;

    /**
     * @var bool
     *
     * @ORM\Column(name="answer_result", type="boolean", unique=true)
     */
    private $answerResult;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", nullable=false)
     * @var $question Question
     */
    private $question;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set answer
     *
     * @param string $answer
     *
     * @return Answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set answerResult
     *
     * @param boolean $answerResult
     *
     * @return Answer
     */
    public function setAnswerResult($answerResult)
    {
        $this->answerResult = $answerResult;

        return $this;
    }

    /**
     * Get answerResult
     *
     * @return bool
     */
    public function getAnswerResult()
    {
        return $this->answerResult;
    }

    /**
     * Set question
     *
     * @param \CoreBundle\Entity\Question $question
     *
     * @return Answer
     */
    public function setQuestion(\CoreBundle\Entity\Question $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \CoreBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
