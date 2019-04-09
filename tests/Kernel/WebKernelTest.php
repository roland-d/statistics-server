<?php
/**
 * Joomla! Statistics Server
 *
 * @copyright  Copyright (C) 2013 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

namespace Joomla\StatsServer\Tests\Kernel;

use Joomla\Application\AbstractApplication;
use Joomla\Application\WebApplication;
use Joomla\StatsServer\Kernel\WebKernel;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Test class for \Joomla\StatsServer\Kernel\WebKernel
 */
class WebKernelTest extends TestCase
{
	/**
	 * @testdox The web Kernel is booted with the correct services registered
	 */
	public function testTheWebKernelIsBootedWithTheCorrectServicesRegistered(): void
	{
		$kernel = new class extends WebKernel
		{
			public function getContainer()
			{
				return parent::getContainer();
			}
		};

		$kernel->boot();

		$this->assertTrue($kernel->isBooted());

		$container = $kernel->getContainer();

		$this->assertSame(
			$container->get(LoggerInterface::class),
			$container->get('monolog.logger.application'),
			'The logger should be aliased to the correct service.'
		);

		$this->assertInstanceOf(
			WebApplication::class,
			$container->get(AbstractApplication::class),
			'The AbstractApplication should be aliased to the correct subclass.'
		);
	}
}