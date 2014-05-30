<?php

Class Output2Web {
	public static $dir = NULL;

	public static function dump($data, $opts) {
		if(self::$dir === NULL) return false;

		$opts = array_merge(array(
			'filename' => uniqid(),
			'format' => 'json',
			'meta' => true
		), $opts);

		$filename = self::$dir . DIRECTORY_SEPARATOR . $opts['filename'];

		if($opts['meta'] === true) {
			$data = array(
				'__meta__' => array(
					'length' => count($data),
					'type' => gettype($data)
				),

				'dump' => $data
			);
		}

		if($opts['format'] === 'json') {
			$_data = json_encode($data);
			$filename .= '.json';
		}

		if(!isset($_data)) return false;

		return file_put_contents($filename, $_data) === false ? false : true;
	}
}