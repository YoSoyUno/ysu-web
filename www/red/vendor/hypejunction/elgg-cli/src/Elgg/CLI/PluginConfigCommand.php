<?php

namespace Elgg\CLI;

use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;

/**
 * site:url CLI command
 */
class PluginConfigCommand extends Command {

	/**
	 * {@inheritdoc}
	 */
	protected function configure() {
		$this->setName('plugin:setting')
				->setDescription('Changes a plugin setting value')
				->addArgument('plugin', InputArgument::OPTIONAL, 'Plugin ID')
				->addArgument('name', InputArgument::OPTIONAL, 'Setting name')
				->addArgument('value', InputArgument::OPTIONAL, 'Setting new value, you can use \'unset\' to unset the setting');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function handle() {

		$plugin = $this->argument('plugin');
		$name = $this->argument('name');
		$value = $this->argument('value');

		if (!elgg_plugin_exists($plugin)) {
			system_message("Abort! The plugin $plugin doesn't exist");
			return;
		}

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

	}

}
