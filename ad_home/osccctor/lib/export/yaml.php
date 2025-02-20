<?php
/**
 * This file is a part of MyWebSQL package
 * export functionality for YAML
 *
 * @file:      lib/export/yaml.php
 * @author     Samnan ur Rehman
 * @copyright  (c) 2008-2014 Samnan ur Rehman
 * @web        http://mywebsql.net
 * @license    http://mywebsql.net/license
 */

if (defined("CLASS_EXPORT_YAML_INCLUDED"))
	return true;

define("CLASS_EXPORT_YAML_INCLUDED", "1");

class Export_yaml {
	var $db;
	var $options;

	function __construct(&$db, $options) {
		$this->db = $db;
		$this->options = $options;
	}

	function createHeader($field_info) {
		return "%YAML 1.1\n---\n# Generated by MyWebSQL\n";
	}

	function createFooter($field_info) {
		return '...';
	}

	function createLine($row, $field_info) {
		$x = count($row);
		$res = "-\n";
		for($i=0; $i<$x; $i++) {
			$res .= '  ' . $field_info[$i]->name . ': ';
			if (empty($row[$i]))
				$res .= "\"\"";
			else if ($field_info[$i]->numeric == 1 && $field_info[$i]->type != 'binary')  // needed for certain timestamp fields
				$res .= $row[$i];
			else
				$res .= "\"". $this->db->escape($row[$i]) . "\"";

			$res .= "\n";
		}

		return $res;
	}
}
?>