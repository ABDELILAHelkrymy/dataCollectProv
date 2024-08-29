<?php

namespace entities;

use core\Entity;

class CourriersDepart extends Entity
{
    protected $id;
    protected $type;
    protected $objet;
    protected $numero;
    protected $date;
    protected $observations;

    const _TYPES = [
        'Bordereau',
        'courrier',
        'colis',
    ];

    public function getTypes()
    {
        return self::_TYPES;
    }
}