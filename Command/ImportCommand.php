<?php

namespace Smirik\QuizBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Smirik\QuizBundle\Entity\Quiz;
use Smirik\QuizBundle\Entity\Question;
use Smirik\QuizBundle\Entity\Answer;

class ImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('smirik:quiz:import')
            ->setDescription('Import quiz data')
            ->addOption('file', null, InputOption::VALUE_REQUIRED, 'Full path to file')
            ->addOption('debug', null, InputOption::VALUE_NONE, 'Do not add to database')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
      $file  = $input->getOption('file');
      $debug = $input->getOption('debug');

      $em = $this->getContainer()->get('doctrine')->getEntityManager();

      $output->writeln('<info>Starting import.</info>');
      
      if (!file_exists($file))
      {
        $output->writeln('<error>File not found!</error>');
        return false;
      }
      
      $fd = fopen($file, 'r');
      
      while (!feof($fd))
      {
        $line = fgets($fd, 4096);
        $data = explode(';', $line);
        
        if ($data[0] == 'quiz')
        {
          /**
           * Creating new Quiz
           */
          $quiz = new Quiz();
          $quiz->setTitle($data[1]);
          $quiz->setDescription($data[2]);
          $quiz->setTime($data[3]);
          $quiz->setNumQuestions($data[4]);
          $quiz->setIsActive($data[5]);
          $quiz->setIsOpened($data[6]);
          
          if ($debug)
          {
            $output->writeln('<comment>Create quiz '.$data[1].'</comment>');
          } else
          {
            $em->persist($quiz);
            $em->flush();
          }
        }
        
        if ($data[0] == 'question')
        {
          /**
           * Creating question
           * Structure: type of record, title, type, file, number of answers, 
           */
          $question = new Question();
          $question->setQuiz($quiz);
          $question->setText($data[1]);
          $question->setType($data[2]);
          $question->setNumAnswers($data[4]);
          
          if ($debug)
          {
            $output->writeln('<comment>Add question '.$question->getText()."</comment>");
          } else
          {
            $em->persist($question);
            $em->flush();
          }
          
          /**
           * question;Укажите число C, такое что A<C<B, где A=2003<sub>4</sub>, B=b1<sub>12</sub>;radio;;4;answer;1000110<sub>2</sub>;;0;204<sub>8</sub>;;1;11210<sub>3</sub>;;0;85<sub>16</sub>;;0;;;
           * Add answers 
           */ 
          for ($i=0; $i<$data[4]; $i++)
          {
            $answer = new Answer();
            $answer->setQuestion($question);
            $answer->setTitle($data[6+$i*3]);
            $answer->setFile($data[7+$i*3]);
            $answer->setIsRight($data[8+$i*3]);
            
            if ($debug)
            {
              $output->writeln('<comment>Add answer '.$answer->getTitle()."</comment>");
            } else
            {
              $em->persist($answer);
              $em->flush();
            }
          }
          
           
        }
        
      }
      
      $output->writeln('<info>All data were added.</info>');

    }
}