<?php
declare(strict_types=1);

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Cli\Di\FactoryDefault\Cli;

use CliTester;

class SetInternalEventsManagerCest
{
    /**
     * Tests Phalcon\Di\FactoryDefault\Cli :: setInternalEventsManager()
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function diFactorydefaultCliSetInternalEventsManager(CliTester $I)
    {
        $I->wantToTest('Di\FactoryDefault\Cli - setInternalEventsManager()');
        $I->skipTest('Need implementation');
    }
}