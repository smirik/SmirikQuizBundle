<?php

namespace Smirik\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Smirik\QuizBundle\Entity\UserQuestion
 *
 * @ORM\Table(name="smirik_users_questions")
 * @ORM\Entity
 */
class UserQuestion
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
     * @var integer $user_id
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="Smirik\UserBundle\Entity\User", inversedBy="fos_user")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var integer $quiz_id
     *
     * @ORM\Column(name="quiz_id", type="integer")
     */
    private $quiz_id;

    /**
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="smirik_quiz")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */
    private $quiz;

    /**
     * @var integer $question_id
     *
     * @ORM\Column(name="question_id", type="integer")
     */
    private $question_id;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="smirik_questions")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;

    /**
     * @var integer $answer
     *
     * @ORM\Column(name="answer", type="integer")
     */
    private $answer;

    /**
     * @var boolean $is_right
     *
     * @ORM\Column(name="is_right", type="boolean")
     */
    private $is_right;

    /**
     * @var boolean $is_closed
     *
     * @ORM\Column(name="is_closed", type="boolean")
     */
    private $is_closed;


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
     * Set user_id
     *
     * @param integer $userId
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set quiz_id
     *
     * @param integer $quizId
     */
    public function setQuizId($quizId)
    {
        $this->quiz_id = $quizId;
    }

    /**
     * Get quiz_id
     *
     * @return integer 
     */
    public function getQuizId()
    {
        return $this->quiz_id;
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
     * Set answer
     *
     * @param integer $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get answer
     *
     * @return integer 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set is_right
     *
     * @param boolean $isRight
     */
    public function setIsRight($isRight)
    {
        $this->is_right = $isRight;
    }

    /**
     * Get is_right
     *
     * @return boolean 
     */
    public function getIsRight()
    {
        return $this->is_right;
    }

    /**
     * Set is_closed
     *
     * @param boolean $isClosed
     */
    public function setIsClosed($isClosed)
    {
        $this->is_closed = $isClosed;
    }

    /**
     * Get is_closed
     *
     * @return boolean 
     */
    public function getIsClosed()
    {
        return $this->is_closed;
    }

    /**
     * Set user
     *
     * @param Smirik\UserBundle\Entity\User $user
     */
    public function setUser(\Smirik\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Smirik\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set quiz
     *
     * @param Smirik\QuizBundle\Entity\Quiz $quiz
     */
    public function setQuiz(\Smirik\QuizBundle\Entity\Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    /**
     * Get quiz
     *
     * @return Smirik\QuizBundle\Entity\Quiz 
     */
    public function getQuiz()
    {
        return $this->quiz;
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
}