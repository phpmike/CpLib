<?php
/**
 * Author: Michaël VEROUX
 * Date: 05/07/15
 * Time: 11:58
 */

namespace Mv\Cp\Converter;

/**
 * Usages:
 *          DateNumero::createFromNumber(6)->dateFr(); // return 01/03/2008
 *          DateNumero::createFromDate('25/03/2008')->number(); // return 6
 *          DateNumero::createFromDate(new \DateTime())->number(); // return current
 *
 * Class DateNumero
 * @package Mv\Cp\Converter
 * @author Michaël VEROUX
 */
class DateNumero
{
    const DATE_FR_PATTERN = '/^\d{2}\/\d{2}\/\d{4}$/';
    const DATE_FR_FORMAT = 'd/m/Y';
    const DATE_MYSQL_FORMAT = 'Y-m-d';
    const DATE_FR_START_BIMESTRIEL = '01/03/2007';
    const DATE_FR_START_TRIMESTRIEL = '01/03/2009';
    const NUMBER_LAST_BIMESTRIEL = 9;

    /**
     * Bimestriel par défaut (faut bien en choisir 1)
     * @var int
     */
    protected $monthNumber = 2;

    /**
     * @var \DateTime
     */
    protected $dateStart;

    /**
     * @var int|string|null
     */
    protected $number;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @param int|string|null $number
     * @param \DateTime $date
     * @throws \LogicException
     */
    protected function __construct($number = null, \DateTime $date = null)
    {
        if (null !== $number && null !== $date) {
            throw new \LogicException('Something is wrong!');
        }

        if (null !== $number) {
            $this->number = (int) $number;
        }

        $this->date = $date;

        if ($number > static::NUMBER_LAST_BIMESTRIEL) {
            $this->monthNumber = 3;
            $this->dateStart = $this->getDateTimeFromDateFr(static::DATE_FR_START_TRIMESTRIEL);
        } elseif (null !== $number) {
            $this->dateStart = $this->getDateTimeFromDateFr(static::DATE_FR_START_BIMESTRIEL);
        }

        if (
            $date instanceof \DateTime
            && 0 === $this->getDateTimeFromDateFr(static::DATE_FR_START_TRIMESTRIEL)->diff($date)->invert
        ) {
            $this->monthNumber = 3;
            $this->dateStart = $this->getDateTimeFromDateFr(static::DATE_FR_START_TRIMESTRIEL);
        } elseif ($date instanceof \DateTime) {
            $this->dateStart = $this->getDateTimeFromDateFr(static::DATE_FR_START_BIMESTRIEL);
        }
    }

    /**
     * @param string $date
     * @return \DateTime
     * @author Michaël VEROUX
     */
    private function getDateTimeFromDateFr($date)
    {
        $dateTime = \DateTime::createFromFormat(static::DATE_FR_FORMAT, $date);
        $dateTime->setTime(0, 0);

        return $dateTime;
    }

    /**
     * @return \DateTime
     * @throws \RuntimeException
     * @author Michaël VEROUX
     */
    public function date()
    {
        if (null !== $this->date) {
            return $this->date;
        }

        if (null === $this->number) {
            throw new \RuntimeException('Bad call.');
        }

        $changeFormatCorrect = 2 < $this->monthNumber ? static::NUMBER_LAST_BIMESTRIEL : 0;

        $this->date = $this->dateStart->add(new \DateInterval(sprintf('P%dM', ($this->number - 1 - $changeFormatCorrect) * $this->monthNumber)));

        return $this->date;
    }

    /**
     * @return string jj/mm/yyyy
     * @author Michaël VEROUX
     */
    public function dateFr()
    {
        return $this->date()->format(static::DATE_FR_FORMAT);
    }

    /**
     * @return string yyyy-mm-dd
     * @author Michaël VEROUX
     */
    public function dateMysql()
    {
        return $this->date()->format(static::DATE_MYSQL_FORMAT);
    }

    /**
     * @return int
     * @throws \RuntimeException
     * @author Michaël VEROUX
     */
    public function number()
    {
        if (null !== $this->number) {
            return $this->number;
        }

        if (null === $this->date) {
            throw new \RuntimeException('Bad call.');
        }

        $diffToTrimestrielStart = $this->date->diff($this->getDateTimeFromDateFr(static::DATE_FR_START_TRIMESTRIEL));

        if (3 > $this->monthNumber && 181 >= $diffToTrimestrielStart->format('%a')) {
            $this->number = 9;

            return $this->number;
        }

        $monthsFromStart = 1 + $this->dateStart->diff($this->date)->format('%m')
                           + $this->dateStart->diff($this->date)->format('%y') * 12;

        $this->number = (int) ceil($monthsFromStart / $this->monthNumber);

        if (2 < $this->monthNumber) {
            $this->number += static::NUMBER_LAST_BIMESTRIEL;
        }

        return $this->number;
    }

    /**
     * @param $number
     * @return DateNumero
     * @author Michaël VEROUX
     */
    static public function createFromNumber($number)
    {
        $dateNumero = new static($number);

        return $dateNumero;
    }

    /**
     * @param \DateTime|string $date dd/mm/yyyy
     * @return DateNumero
     * @throws \RuntimeException
     * @author Michaël VEROUX
     */
    static public function createFromDate($date)
    {
        if (!$date instanceof \DateTime && !preg_match(static::DATE_FR_PATTERN, $date)) {
            throw new \RuntimeException(sprintf('Bad date "%s" given.', $date));
        } elseif (!$date instanceof \DateTime) {
            $date = \DateTime::createFromFormat(static::DATE_FR_FORMAT, $date);
        }

        $date->setTime(0, 0);

        $date->setDate((int) $date->format('Y'), (int) $date->format('m'), 1); // to limit side effect
        $dateNumero = new static(null, $date);

        return $dateNumero;
    }
} 