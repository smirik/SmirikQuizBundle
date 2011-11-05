<?php

namespace Smirik\QuizBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Smirik\QuizBundle\Model\Question as ModelQuestion;

/**
 * Smirik\QuizBundle\Entity\Question
 *
 * @ORM\Table(name="smirik_questions")
 * @ORM\Entity(repositoryClass="Smirik\QuizBundle\Entity\QuestionRepository")
 */
class Question extends ModelQuestion
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
     * @var integer $quiz_id
     *
     * @ORM\Column(name="quiz_id", type="integer")
     */
    private $quiz_id;

    /**
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="smirik_quiz", cascade={"all"})
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */
    private $quiz;

    /**
     * @var text $text
     *
     * @ORM\Column(name="text", type="text", nullable="true")
     */
    private $text;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=50, nullable="true")
     */
    private $type;

    /**
     * @var string $file
     *
     * @ORM\Column(name="file", type="string", length=255, nullable="true")
     */
    private $file;

    /**
     * @var integer $num_answers
     *
     * @ORM\Column(name="num_answers", type="integer")
     */
    private $num_answers;

    /**
     * @var date $created_at
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    protected $created_at;

    /**
     * @var date $updated_at
     *
     * @ORM\Column(type="datetime", nullable=TRUE)
     * @Gedmo\Timestampable(on="update")
     */
    protected $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"all"})
     */
    protected $answers;

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
     * Set text
     *
     * @param text $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get text
     *
     * @return text 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
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
     * Set num_answers
     *
     * @param integer $numAnswers
     */
    public function setNumAnswers($numAnswers)
    {
        $this->num_answers = $numAnswers;
    }

    /**
     * Get num_answers
     *
     * @return integer 
     */
    public function getNumAnswers()
    {
        return $this->num_answers;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
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
    
    public function __construct()
    {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add answers
     *
     * @param Smirik\QuizBundle\Entity\Answer $answers
     */
    public function addAnswer(\Smirik\QuizBundle\Entity\Answer $answers)
    {
        $this->answers[] = $answers;
    }

    /**
     * Get answers
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAnswers()
    {
        return $this->answers;
    }
    
}