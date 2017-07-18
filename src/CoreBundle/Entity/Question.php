<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;
use CoreBundle\Entity\Answer;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    protected $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="duration", type="datetime", nullable=true)
     */
    protected $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="question_type", type="string")
     */
    protected $questionType;

    /**
     *
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     * @var Answer[]
     */
    private $answers;


    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }


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
     * Set content
     *
     * @param string $content
     *
     * @return Question
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set duration
     *
     * @param \DateTime $duration
     *
     * @return Question
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return \DateTime
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set questionType
     *
     * @param string $questionType
     *
     * @return Question
     */
    public function setQuestionType($questionType)
    {
        $this->questionType = $questionType;

        return $this;
    }

    /**
     * Get questionType
     *
     * @return string
     */
    public function getQuestionType()
    {
        return $this->questionType;
    }

    /**
     * Add answer
     *
     * @param \CoreBundle\Entity\Answer $answer
     *
     * @return Question
     */
    public function addAnswer(\CoreBundle\Entity\Answer $answer)
    {
        $answer->setQuestion($this);
        $this->getAnswers()->add($answer);
        return $this;
    }

    /**
     * Remove answer
     *
     * @param \CoreBundle\Entity\Answer $answer
     */
    public function removeAnswer(\CoreBundle\Entity\Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }
}
