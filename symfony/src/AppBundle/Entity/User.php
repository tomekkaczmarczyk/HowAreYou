<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Answers", mappedBy="user")
     */
    protected $answers;

    public function __construct()
    {
        parent::__construct();
        $this->answers = new ArrayCollection();
    }

    /**
     * Set answer
     *
     * @param \AppBundle\Entity\Answers $answer
     * @return User
     */
    public function setAnswer(\AppBundle\Entity\Answers $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return \AppBundle\Entity\Answers 
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}
