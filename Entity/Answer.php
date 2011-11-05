<?php

namespace Smirik\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Smirik\QuizBundle\Entity\Answer
 *
 * @ORM\Table(name="smirik_answers")
 * @ORM\Entity
 */
class Answer
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $question_id
     *
     * @ORM\Column(name="question_id", type="integer")
     */
    private $question_id;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="smirik_questions", cascade={"all"})
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable="true")
     */
    private $title;

    /**
     * @var string $file
     *
     * @ORM\Column(name="file", type="string", length=255, nullable="true")
     */
    private $file;

    /**
     * @var string $is_right
     *
     * @ORM\Column(name="is_right", type="string", length=255, nullable="true")
     */
    private $is_right = false;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set question_id
     *
     * @param integer $questionId
     */
    public function setQuestionId($questionId)
    {
        $this->question_id = $questionId;
    }

    /**
     * Get question_id
     *
     * @return integer 
     */
    public function getQuestionId()
    {
        return $this->question_id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set question
     *
     * @param Smirik\QuizBundle\Entity\Question $question
     */
    public function setQuestion(\Smirik\QuizBundle\Entity\Question $question)
    {
        $this->question = $question;
    }

    /**
     * Get question
     *
     * @return Smirik\QuizBundle\Entity\Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set is_right
     *
     * @param string $isRight
     */
    public function setIsRight($isRight)
    {
        $this->is_right = $isRight;
    }

    /**
     * Get is_right
     *
     * @return string 
     */
    public function getIsRight()
    {
        return $this->is_right;
    }
}