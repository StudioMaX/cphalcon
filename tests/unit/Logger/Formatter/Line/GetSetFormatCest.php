<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Test\Unit\Logger\Formatter\Line;

use Phalcon\Logger\Formatter\Line;
use UnitTester;

class GetSetFormatCest
{
    /**
     * Tests Phalcon\Logger\Formatter\Line :: getFormat()/setFormat()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2018-11-13
     */
    public function loggerFormatterLineGetSetFormat(UnitTester $I)
    {
        $I->wantToTest('Logger\Formatter\Line - getFormat()/setFormat()');

        $formatter = new Line();
        $expected  = '[%date%][%level%] %message%';
        $actual    = $formatter->getFormat();

        $I->assertEquals($expected, $actual);

        $format = '%message%-[%date%]-[%level%]';
        $formatter->setFormat($format);

        $expected = $format;
        $actual   = $formatter->getFormat();
        $I->assertEquals($expected, $actual);
    }
}
