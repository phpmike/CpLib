<?php

Namespace Mv\Cp\Content;

/**
 * Author: Michaël VEROUX
 * Date: 13/07/15
 * Time: 10:05
 */
class Mag
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $numero;

    /**
     * @var array
     */
    private $mag = array();

    /**
     * Cp constructor.
     */
    public function __construct()
    {
        $this->mag = array(
            0  => array(
                'section'   => 'home',
                'rubriques' => 'Accueil',
                'dossier'   => 'home',
            ),
            1  => array(
                'section'   => 'actualites',
                'rubriques' => 'C dans l\'eau',
                'dossier'   => 'c_dans_l_eau',
            ),
            2  => array(
                'section'   => 'actualites',
                'rubriques' => 'Nouvelles vagues',
                'dossier'   => 'nouvelles_vagues',
            ),
            3  => array(
                'section'   => 'techniques',
                'rubriques' => 'Un poisson, une technique',
                'dossier'   => 'de_pere_en_fils',
            ),
            4  => array(
                'section'   => 'techniques',
                'rubriques' => 'Leurre de vérité',
                'dossier'   => 'leurre_de_verite',
            ),
            5  => array(
                'section'   => 'techniques',
                'rubriques' => 'Embarqué',
                'dossier'   => 'embarque',
            ),
            6  => array(
                'section'   => 'techniques',
                'rubriques' => 'Loin de chez nous',
                'dossier'   => 'loin_de_chez_nous',
            ),
            7  => array(
                'section'   => 'investigations',
                'rubriques' => 'Electronique',
                'dossier'   => 'electronique',
            ),
            8  => array(
                'section'   => 'investigations',
                'rubriques' => 'De fond en comble',
                'dossier'   => 'de_fond_en_comble',
            ),
            9  => array(
                'section'   => 'connaissances',
                'rubriques' => 'Pêché-Mangé',
                'dossier'   => 'peche_mange',
            ),
            10 => array(
                'section'   => 'connaissances',
                'rubriques' => 'Environnement',
                'dossier'   => 'environnement',
            ),
            11 => array(
                'section'   => 'connaissances',
                'rubriques' => 'Portfolio',
                'dossier'   => 'portfolio',
            ),
            12 => array(
                'section'   => 'bateau',
                'rubriques' => 'Essai bateau',
                'dossier'   => 'test_bateau',
            ),
            13 => array(
                'section'   => 'techniques',
                'rubriques' => 'A pied du bord',
                'dossier'   => 'a_pied_du_bord',
            ),
        );
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param int $numero
     * @return $this
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return string
     * @author Michaël VEROUX
     */
    public function section()
    {
        if (null === $this->id) {
            $this->id = 0;
        }

        return $this->mag[$this->id]['section'];
    }

    /**
     * @return array
     * @author Michaël VEROUX
     */
    public function getDossiers()
    {
        $dossiers = array_map(function ($value){
            return $value['dossier'];
        }, $this->mag);

        return array_unique($dossiers);
    }
}