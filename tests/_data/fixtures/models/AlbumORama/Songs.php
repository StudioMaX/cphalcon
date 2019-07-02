<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Models\AlbumORama;

use Phalcon\Mvc\Model\AbstractModel;

class Songs extends AbstractModel
{
    public function initialize()
    {
        $this->hasMany(
            'id',
            Albums::class,
            'albums_id',
            [
                'alias' => 'album',
            ]
        );
    }
}