<?php

Class Parallelbug {
	public static $dir = NULL; // No trailing slash
	public static $settings = array(
		//'filename' => uniqid(),
		'format' => 'json',
		'meta' => true,
		'meta_key' => '__meta__',
		'date_format' => 'Y-m-d H:i:s',
		'append' => false,
		'data_key' => 'dump',
		'append_group_key' => '__append_group__'
	);

	public static function dump($data, $opts) {
		// Do not accept dump if $dir is unset
		if(self::$dir === NULL) return false;

		// Default params
		$settings = self::$settings;
		$settings['filename'] = uniqid();

		$opts = array_merge($settings, $opts);

		// Construct filepath
		$filename = self::$dir . DIRECTORY_SEPARATOR . $opts['filename'];

		if($opts['meta'] === true) {
			$now = time();

			// Generate structure with meta
			$data = array(
				$opts['meta_key'] => array(
					'length' => count($data),
					'type' => gettype($data),
					'timestamp' => $now,
					'timestamp_pretty' => date($opts['date_format'], $now)
				),

				$opts['data_key'] => $data
			);
		}

		if($opts['format'] === 'json') {
			// Ensure extension
			$filename .= '.json';

			if($opts['append'] === true) {
				// Grab old dump - This is so that we can properly append the new data
				$old_data = file_get_contents($filename);
				if($old_data === false) return false;

				$_old_data = json_decode($old_data, true);

				if(in_array($opts['append_group_key'], $_old_data)) {
					// The old data is already in an append group, so just push new data
					$tmp = $_old_data;
					$tmp[] = $data;

					$data = $tmp;
					unset($tmp);
				} else {
					// The old data is not in an append group, so create structure
					$tmp = array(
						$opts['append_group_key'],
						$_old_data,
						$data
					);
					$data = $tmp;
					unset($tmp);
				}
			}

			$_data = json_encode($data);
		}

		if(!isset($_data)) return false;
		// Place dump in file. The ternary enforces accurate boolean return. Do not use !! as this will give false positives.
		return file_put_contents($filename, $_data) === false ? false : true;
	}
}
