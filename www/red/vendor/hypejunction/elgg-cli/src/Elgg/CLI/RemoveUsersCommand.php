<?php

namespace Elgg\CLI;

use Elgg\Application;
use Elgg\Http\Request;
use ElggBatch;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * route CLI command
 */
class RemoveUsersCommand extends Command {

	/**
	 * {@inheritdoc}
	 */
	protected function configure() {
		$this->setName('remove:users')
				->setDescription('Execute an action');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function handle() {

		set_time_limit(0);
		$options = array(
		    'type' => 'user',
		    'limit' => false
		);


		$batch_size = 1000;
		$users = new ElggBatch('elgg_get_entities', $options, null, $batch_size);
		$admins = [];

		$ia = elgg_set_ignore_access(true);
		foreach ($users as $user) {
			if (elgg_is_admin_user($user->guid)) {
				array_push($admins,$user);
			} else {
				if ($user->delete()) {
					system_message("Deleted user: $user->guid");
				} else {
					system_message("Not deleted: $user->guid");
				}
			}
		}
		elgg_set_ignore_access($ia);

		foreach ($admins as $key => $admin) {
			$out .= ' '.$admin->guid;
		}
		system_message("Note deleted users (admins): $out");

	}

}
