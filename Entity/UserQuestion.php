<?php

namespace Smirik\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Smirik\QuizBundle\Model\UserQuestion as ModelUserQuestion;

/**
 * Smirik\QuizBundle\Entity\UserQuestion
 *
 * @ORM\Table(name="smirik_users_questions")
 * @ORM\Entity
 */
class UserQuestion extends ModelUserQuestion
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
     * @ORM\ManyToOne(targetEntity="Smirik\QuizBundle\Entity\User", inversedBy="fos_user")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
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
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id", onDelete="CASCADE")
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
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $question;

    /**
     * @var integer $user_quiz_id
     *
     * @ORM\Column(name="user_quiz_id", type="integer")
     */
    private $user_quiz_id;

    /**
     * @ORM\ManyToOne(targetEntity="UserQuiz", inversedBy="smirik_users_quiz")
     * @ORM\JoinColumn(name="user_quiz_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user_quiz;

    /**
     * @var integer $answer_id
     *
     * @ORM\Column(name="answer_id", type="integer", nullable="true")
     */
    private $answer_id;

    /**
     * @ORM\ManyToOne(targetEntity="Answer", inversedBy="smirik_answers")
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $answer;

    /**
     * @var string $answer_text
     *
     * @ORM\Column(name="answer_text", type="string", length=200, nullable="true")
     */
    private $answer_text;

    /**
     * @var boolean $is_right
     *
     * @ORM\Column(name="is_right", type="boolean", nullable="true")
     */
    private $is_right = false;

    /**
     * @var boolean $is_closed
     *
     * @ORM\Column(name="is_closed", type="boolean", nullable="true")
     */
    private $is_closed = false;


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
     * @param Smirik\QuizBundle\Entity\User $user
     */
    public function setUser(\Smirik\QuizBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Smirik\QuizBundle\Entity\User 
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


    /**
     * Set user_quiz_id
     *
     * @param integer $userQuizId
     */
    public function setUserQuizId($userQuizId)
    {
        $this->user_quiz_id = $userQuizId;
    }

    /**
     * Get user_quiz_id
     *
     * @return integer 
     */
    public function getUserQuizId()
    {
        return $this->user_quiz_id;
    }

    /**
     * Set user_quiz
     *
     * @param Smirik\QuizBundle\Entity\UserQuiz $userQuiz
     */
    public function setUserQuiz(\Smirik\QuizBundle\Entity\UserQuiz $userQuiz)
    {
        $this->user_quiz = $userQuiz;
    }

    /**
     * Get user_quiz
     *
     * @return Smirik\QuizBundle\Entity\UserQuiz 
     */
    public function getUserQuiz()
    {
        return $this->user_quiz;
    }

    /**
     * Set answer_id
     *
     * @param integer $answerId
     */
    public function setAnswerId($answerId)
    {
        $this->answer_id = $answerId;
    }

    /**
     * Get answer_id
     *
     * @return integer 
     */
    public function getAnswerId()
    {
        return $this->answer_id;
    }

    /**
     * Set answer
     *
     * @param Smirik\QuizBundle\Entity\Answer $answer
     */
    public function setAnswer(\Smirik\QuizBundle\Entity\Answer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get answer
     *
     * @return Smirik\QuizBundle\Entity\Answer 
     */
    public function getAnswer()
    {
        return $this->answer;
    }
    

    /**
     * Set answer_text
     *
     * @param string $answerText
     */
    public function setAnswerText($answerText)
    {
        $this->answer_text = $answerText;
    }

    /**
     * Get answer_text
     *
     * @return string 
     */
    public function getAnswerText()
    {
        return $this->answer_text;
    }
    
}