<?php

namespace Tatweer\TrainingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrainingExpenses
 *
 * @ORM\Table(name="training_expenses", indexes={@ORM\Index(name="training_expenses_triningid_fk_idx", columns={"training_id"}), @ORM\Index(name="training_expenses_expenseclassid_fk", columns={"expense_class_id"})})
 * @ORM\Entity
 */
class TrainingExpenses
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_training_expense", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTrainingExpense;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer", nullable=true)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="remarks", type="text", nullable=true)
     */
    private $remarks;

    /**
     * @var \TrainingExpensesClasses
     *
     * @ORM\ManyToOne(targetEntity="TrainingExpensesClasses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="expense_class_id", referencedColumnName="id_class")
     * })
     */
    private $expenseClass;

    /**
     * @var \Trainings
     *
     * @ORM\ManyToOne(targetEntity="Trainings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="training_id", referencedColumnName="id_training")
     * })
     */
    private $training;



    /**
     * Get idTrainingExpense
     *
     * @return integer 
     */
    public function getIdTrainingExpense()
    {
        return $this->idTrainingExpense;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return TrainingExpenses
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     * @return TrainingExpenses
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string 
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set expenseClass
     *
     * @param \Tatweer\TrainingBundle\Entity\TrainingExpensesClasses $expenseClass
     * @return TrainingExpenses
     */
    public function setExpenseClass(\Tatweer\TrainingBundle\Entity\TrainingExpensesClasses $expenseClass = null)
    {
        $this->expenseClass = $expenseClass;

        return $this;
    }

    /**
     * Get expenseClass
     *
     * @return \Tatweer\TrainingBundle\Entity\TrainingExpensesClasses 
     */
    public function getExpenseClass()
    {
        return $this->expenseClass;
    }

    /**
     * Set training
     *
     * @param \Tatweer\TrainingBundle\Entity\Trainings $training
     * @return TrainingExpenses
     */
    public function setTraining(\Tatweer\TrainingBundle\Entity\Trainings $training = null)
    {
        $this->training = $training;

        return $this;
    }

    /**
     * Get training
     *
     * @return \Tatweer\TrainingBundle\Entity\Trainings 
     */
    public function getTraining()
    {
        return $this->training;
    }
}
