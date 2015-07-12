<?php

namespace Mv\Cp;

use Mv\Cp\Converter\DateNumero;
use Mv\Cp\Content\Mag;

/**
 * Author: Michaël VEROUX
 * Date: 12/07/15
 * Time: 09:42
 */
class Cp
{
    /**
     * @var string|null
     */
    private $lastNumero;

    /**
     * @var Mag
     */
    private $mag;

    /**
     * Cp constructor.
     */
    public function __construct($id = 0, $numero = null)
    {
        $this->mag = new Mag();
        $this->mag->setId($id);

        if(null === $numero) {
            $numero = $this->lastNumero();
        }

        $this->mag->setNumero($numero);
    }

    static function numeroValide($numero)
    {
        if(10 > (int) $numero) {
            $numero = sprintf('0%s', $numero);
        }

        $contentDirectory = sprintf(CONTENU_DIR_PATTERN, $numero);

        if(!is_dir($contentDirectory)) {
            static::numeroValide((int) $numero--);
        }

        return (string) $numero;
    }

    public function lastNumero()
    {
        if(null === $this->lastNumero) {
            $this->lastNumero = static::numeroValide(DateNumero::createFromDate(new \DateTime())->number());
        }

        return $this->lastNumero;
    }

    /**
     * @return Mag
     */
    public function getMag()
    {
        return $this->mag;
    }
}