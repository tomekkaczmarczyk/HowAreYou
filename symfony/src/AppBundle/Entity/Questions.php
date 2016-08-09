<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\QuestionsRepository")
 */
class Questions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=65535)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="questions")
     */
    private $test;

    /**
     * @ORM\OneToMany(targetEntity="Answers", mappedBy="question")
     */
    private $answers;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxQ", type="integer")
     */
    private $maxQ;


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
     * Set text
     *
     * @param string $text
     * @return Questions
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set maxQ
     *
     * @param integer $maxQ
     * @return Questions
     */
    public function setMaxQ($maxQ)
    {
        $this->maxQ = $maxQ;

        return $this;
    }

    /**
     * Get maxQ
     *
     * @return integer 
     */
    public function getMaxQ()
    {
        return $this->maxQ;
    }
}