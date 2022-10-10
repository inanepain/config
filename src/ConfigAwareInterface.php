<?php

/**
 * Inane: Config
 *
 * Inane Standard Library
 *
 * PHP version 8.1
 *
 * @author Philip Michael Raab<peep@inane.co.za>
 * @package Inane\Config
 *
 * @license UNLICENSE
 * @license https://github.com/inanepain/stdlib/raw/develop/UNLICENSE UNLICENSE
 *
 * @version $Id$
 * $Date$
 */

/**
 * Examples (controller & Service)
 * Using a config key: myconfig
 *
 * config/autoload/myconfig.global.php
 *
 * return array(
 *    'myconfig' => ['test' => true],
 *);
 *
 * Module.php
 *
 * use Inane\Config\ConfigAwareInterface;
 *
 * public function getControllerConfig() {
 *		return array(
 *			'initializers' => array(
 *				function ($instance, $sm) {
 *					if ($instance instanceof ConfigAwareInterface) {
 *						$locator = $sm->getServiceLocator();
 *						$config = $locator->get('Config');
 *						$instance->setConfig($config['myconfig']);
 *					}
 *				}));
 *	}
 *
 * public function getServiceConfig() {
 * 		return array(
 * 			'initializers' => array(
 * 				function ($instance, $sm) {
 * 					if ($instance instanceof ConfigAwareInterface) {
 * 						$config = $sm->get('Config');
 * 						$instance->setConfig($config['myconfig']);
 * 					}
 * 				}));
 * 	}
 *
 * IndexController.php
 *
 * use Inane\Config\ConfigAwareInterface;
 *
 * class IndexController extends AbstractActionController implements ConfigAwareInterface {
 *
 * protected $config;
 *
 * 	public function setConfig($config) {
 * 		$this->config = $config;
 * 	}
 */

declare(strict_types=1);

namespace Inane\Config;

use Laminas\Config\Config;

/**
 * ConfigAwareInterface
 *
 * @package Inane\Config
 *
 * @version 0.1.0
 */
interface ConfigAwareInterface {
	/**
	 * configuration
	 *
	 * @param array|\Inane\Stdlib\Options|\Laminas\Config\Config $config configuration
	 *
	 * @return void
	 */
	public function setConfig(array|\Inane\Stdlib\Options|Config $config): void;
}
