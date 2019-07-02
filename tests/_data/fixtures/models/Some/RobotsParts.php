<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Models\Some;

use Phalcon\Mvc\Model\AbstractModel;

class RobotsParts extends AbstractModel
{
    public function initialize()
    {
        $this->setSource('robots_parts');

        $this->belongsTo(
            'parts_id',
            Parts::class,
            'id',
            [
                'foreignKey' => true,
            ]
        );

        $this->belongsTo(
            'robots_id',
            Robots::class,
            'id',
            [
                'foreignKey' => [
                    'message' => 'The robot code does not exist',
                ],
            ]
        );
    }
}