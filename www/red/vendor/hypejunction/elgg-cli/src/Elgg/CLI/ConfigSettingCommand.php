<?php

namespace Elgg\CLI;

use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;

/**
 * site:url CLI command
 */
class ConfigSettingCommand extends Command {

	/**
	 * {@inheritdoc}
	 */
	protected function configure() {
		$this->setName('config:setting')
				->setDescription('Changes a system config or plugin setting value')
				->addArgument('name', InputArgument::REQUIRED, 'Setting name')
				->addArgument('value', InputArgument::OPTIONAL, 'Setting new value, you can use \'unset\' to unset the setting')
				->addArgument('plugin', InputArgument::OPTIONAL, 'Plugin ID');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function handle() {

		$name = $this->argument('name');
		$value = $this->argument('value');
		$plugin = $this->argument('plugin');

		if ($plugin) {
			if (!elgg_plugin_exists($plugin)) {
				system_message("Abort! The plugin $plugin doesn't exist");
				return;
			}

			elgg_set_config('systemcache',0);

			if (isset($value)) {
				if ($value == 'unset') {
					elgg_unset_plugin_setting($name,$plugin);
					system_message("$plugin:$name is now unset");
				} else {
					if (elgg_set_plugin_setting($name,$value,$plugin)) {
						system_message("New value for $plugin:$name is $value");
					}
				}
			} else {
				$actual = elgg_get_plugin_setting($name,$plugin,'none');
				system_message("Actual value for $plugin:$name is $actual");
			}

		} else {

			// System config
			if (isset($value)) {
				if ($value == 'unset') {
					elgg_unset_config($name,0);
					system_message("System config $name is now unset");
				} else {
					if (elgg_save_config($name,$value)) {
						system_message("New value for system config $name is $value");
					}

				}
			} else {
				$actual = elgg_get_config($name,0);
				system_message("Actual value for system config $name is $actual");
			}
		}

	}

}
