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
     * @return mixed
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param mixed $test
     */
    public function setTest($test)
    {
        $this->test = $test;
    }


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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add answers
     *
     * @param \AppBundle\Entity\Answers $answers
     * @return Questions
     */
    public function addAnswer(\AppBundle\Entity\Answers $answers)
    {
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers
     *
     * @param \AppBundle\Entity\Answers $answers
     */
    public function removeAnswer(\AppBundle\Entity\Answers $answers)
    {
        $this->answers->removeElement($answers);
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
