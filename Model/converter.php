<?php
class Converter
{
	public static function toObject(array $array, $object)
	{
		$class = get_class($object);
		$methods = get_class_methods($class);
		foreach ($methods as $method) {
			preg_match(' /^(set)(.*?)$/i', $method, $results);
			$pre = $results[1]  ?? '';
			$k = $results[2]  ?? '';
			$k = strtolower(substr($k, 0, 1)) . substr($k, 1);
			if ($pre == 'set' && !empty($array[$k])) {
				$object->$method($array[$k]);
			}
		}
		return $object;
	}

	public static function toArray($object)
	{
		$array = array();
		$class = get_class($object);
		$methods = get_class_methods($class);
		foreach ($methods as $method) {
			preg_match(' /^(get)(.*?)$/i', $method, $results);
			$pre = $results[1]  ?? '';
			$k = $results[2]  ?? '';
			$k = strtolower(substr($k, 0, 1)) . substr($k, 1);
			if ($pre == 'get') {
				$array[$k] = $object->$method();
			}
		}
		return $array;
	}
}