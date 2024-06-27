<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\NotificationTrait;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, NotificationTrait;

	public function add_errors(&$err, $field, $errMsg){
		if (!array_key_exists($field, $err)) $err[$field] = array();
		array_push($err[$field], $errMsg);
	}

	public function getDirContents($dir, $start_timestamp = "", &$results = array()) {
		$files = scandir($dir);

		foreach ($files as $key => $value) {
			$path = realpath($dir . DIRECTORY_SEPARATOR . $value);
			if (!is_dir($path)) {
				if ($value > $start_timestamp)
					$results[] = $path;
			} else if ($value != "." && $value != "..") {
				$this->getDirContents($path, $start_timestamp, $results);
			}
		}
		return $results;
	}

	public function getUrl($path) {
		$file = explode('/public/', $path);
		return str_replace("http://", "https://", asset($file[1]));
	}

	public function base64ToImage($base64_string, $output_file) {
		$file = fopen($output_file, "wb");

		$data = explode(',', $base64_string);

		//fwrite($file, base64_decode($data[1]));
		fwrite($file, base64_decode($data[0]));
		fclose($file);

		return $output_file;
	}

	public function valideDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = date_create($date);
		if (!$d)
			return false;
		$fd = $d->format($format);
        return ($fd == substr($date, 0, strlen($fd))) || ($date == substr($fd, 0, strlen($date)));
    }

	public function formatDate($date, $format = 'Y-m-d H:i:s')
    {
		if ($date == null || empty($date))
			return null;
        $d = date_create($date);
		if ($d){
			$fd = $d->format($format);
			if (($fd == substr($date, 0, strlen($fd))) || ($date == substr($fd, 0, strlen($date))))
				return $fd;

			return null;
		} else
			return null;
    }

	public function ctrlField_Empty(&$field, &$status_array, $state){
		$blEmpty = 0;
		if (isset($field)){
			$field = trim($field);
			if (empty($field))
				$blEmpty = 1;
		} else
			$blEmpty = 1;
		if ($blEmpty > 0)
			$status_array[] = $state;

		return $blEmpty;
	}

	public function ctrlField_NotFound(&$field, &$status_array, $state, $check){
		$objet = null;
		if (isset($field)){

			if ($check($field, $objet))
				$status[] = $state;
		} else
			$status[] = $state;

		return $objet;
	}

	public function ctrlField_Other(&$field, &$status_array, $state, $check){
		if (isset($field)){
			if ($check())
				$status[] = $state;
		} else
			$status[] = $state;
	}

}
