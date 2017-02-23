<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Friendship
 *
 * @ORM\Table(name="friendships")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FriendshipRepository")
 */
class Friendship
{
    CONST STATUS_WAITING = 0;
    CONST STATUS_ACTIVE = 1;
    CONST STATUS_CANCELED = 2;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="accepted_at", type="datetime", nullable=true)
     */
    private $acceptedAt;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cancelled_at", type="datetime", nullable=true)
     */
    private $cancelledAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="sender_id", nullable=false)
     */
    private $sender;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="receiver_id", nullable=false)
     */
    private $receiver;

    /**
     * @var integer
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;


    /**
     * Friendship constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->status = $this::STATUS_WAITING;
    }

    /**
     * CUSTOM METHODS
     */

    /**
     * Accept a friendship
     */
    public function accept()
    {
        $this->status = $this::STATUS_ACTIVE;
        $this->acceptedAt = new \DateTime();
    }

    /**
     * Cancel a friendship
     */
    public function cancel()
    {
        $this->status = $this::STATUS_CANCELED;
        $this->cancelledAt = new \DateTime();
    }

    /**
     * GETTERS & SETTERS
     */

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Friendship
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set acceptedAt
     *
     * @param \DateTime $acceptedAt
     *
     * @return Friendship
     */
    public function setAcceptedAt($acceptedAt)
    {
        $this->acceptedAt = $acceptedAt;

        return $this;
    }

    /**
     * Get acceptedAt
     *
     * @return \DateTime
     */
    public function getAcceptedAt()
    {
        return $this->acceptedAt;
    }

    /**
     * Set cancelledAt
     *
     * @param \DateTime $cancelledAt
     *
     * @return Friendship
     */
    public function setCancelledAt($cancelledAt)
    {
        $this->cancelledAt = $cancelledAt;

        return $this;
    }

    /**
     * Get cancelledAt
     *
     * @return \DateTime
     */
    public function getCancelledAt()
    {
        return $this->cancelledAt;
    }

    /**
     * @return User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param User $sender
     * @return Friendship
     */
    public function setSender(User $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param User $receiver
     * @return Friendship
     */
    public function setReceiver(User $receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Friendship
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}

