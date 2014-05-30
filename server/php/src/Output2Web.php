<?php

Class Output2Web {
	public static $dir = NULL;

	public static function dump($data, $opts) {
		if(self::$dir === NULL) return false;

		$opts = array_merge(array(
			'filename' => uniqid(),
			'format' => 'json',
			'meta' => true,
			'date_format' => 'Y-m-d H:i:s',
			'append' => false
		), $opts);

		$filename = self::$dir . DIRECTORY_SEPARATOR . $opts['filename'];

		if($opts['meta'] === true) {
			$now = time();

			$data = array(
				'__meta__' => array(
					'length' => count($data),
					'type' => gettype($data),
					'timestamp' => $now,
					'timestamp_pretty' => date($opts['date_format'], $now)
				),

				'dump' => $data
			);
		}

		if($opts['format'] === 'json') {
			$filename .= '.json';

			if($opts['append'] === true) {
				$old_data = file_get_contents($filename);
				if($old_data === false) return false;

				$_old_data = json_decode($old_data, true);

				if(isset($_old_data['__append_group__'])) {
					$tmp = $_old_data;
					$tmp[] = $data;

					$data = $tmp;
					unset($tmp);
				} else {
					$tmp = array(
						'__append_group__',
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
		return file_put_contents($filename, $_data) === false ? false : true;
	}
}