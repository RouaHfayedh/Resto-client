<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Miracode\StripeBundle\Model\AbstractChargeModel;

/**
 * @ORM\Entity()
 * @ORM\Table(name="stripe_charge")
 */
class Charge extends AbstractChargeModel
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;
}