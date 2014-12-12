<?php

namespace Bracket; 

abstract class BracketConfig {
	static $path = "/data/";
	static $ext = ".json";
}

class BracketTable extends BracketConfig {
	private $fullpath;
	private $name;
	private $json;
	private $arr;
	private $temp;
	
	public function __construct($name) {
		$this->name = $name;
		$this->fullpath = dirname(__FILE__).parent::$path.$this->name.parent::$ext;
		$this->json = json_encode(json_decode(file_get_contents($this->fullpath, true)));
		$this->arr = json_decode($this->json);
		return $this;
	}
	
	public function all() {
		return $this->arr;
	}
	
	public function get() {
		if(!empty($this->temp)) {
			return $this->temp;
		} else {
			return $this->arr;
		}
	}
	
	public function count() {
		if(!empty($this->temp)) {
			return count($this->temp);
		} else {
			return count($this->arr);
		}
	}
	
	public function first() {
		return $this->temp[0];
	}
	
	public function max($column) {
		$temp = empty($this->temp) ? $this->arr : $this->temp;
		$i = $temp[0]->$column;
		foreach($temp as $row) {
			if($row->$column >= $i) {
				$i = $row->$column;
			}
		}
		return $i;
	}
	
	public function min($column) {
		$temp = empty($this->temp) ? $this->arr : $this->temp;
		$i = $temp[0]->$column;
		foreach($temp as $row) {
			if($row->$column <= $i) {
				$i = $row->$column;
			}
		}
		return $i;
	}
	
	public function avg($column) {
		$temp = empty($this->temp) ? $this->arr : $this->temp;
		$c = count($temp);
		$sum = 0;
		foreach($temp as $row) {
			$sum += $row->$column;
		}
		$avg = $sum/$c;
		return $avg;
	}
	
	public function sum($column) {
		$temp = empty($this->temp) ? $this->arr : $this->temp;
		$sum = 0;
		foreach($temp as $row) {
			$sum += $row->$column;
		}
		return $sum;
	}
	
	public function find($id, $key="id") {
		foreach($this->arr as $row) {
			if($row->$key==$id) {
				return $row;
			}
		}
	}
	
	public function lists($column) {
		$temp = empty($this->temp) ? $this->arr : $this->temp;
		if(count($temp)>1) {
			foreach($temp as $t) {
				$values[] = $t->$column;
			}
			return $values;
		}
		return $temp[0]->$column;
	}
	
	public function where($column, $operator, $value) {
		foreach($this->arr as $row) {
			switch($operator) {
				case '=':
					if($row->$column == $value) $arr[] = $row;
					break;
				case '==':
					if($row->$column == $value) $arr[] = $row;
					break;
				case '!=':
					if($row->$column != $value) $arr[] = $row;
					break;
				case '<>':
					if($row->$column != $value) $arr[] = $row;
					break;
				case '>':
					if($row->$column > $value) $arr[] = $row;
					break;
				case '<':
					if($row->$column < $value) $arr[] = $row;
					break;
				case '>=':
					if($row->$column >= $value) $arr[] = $row;
					break;
				case '<=':
					if($row->$column <= $value) $arr[] = $row;
					break;
			}
		}
		$this->temp = $arr;
		return $this;
	}
	
	public function andWhere($column, $operator, $value) {
		$arr = array();
		foreach($this->temp as $row) {
			switch($operator) {
				case '=':
					if($row->$column == $value) $arr[] = $row;
					break;
				case '==':
					if($row->$column == $value) $arr[] = $row;
					break;
				case '!=':
					if($row->$column != $value) $arr[] = $row;
					break;
				case '<>':
					if($row->$column != $value) $arr[] = $row;
					break;
				case '>':
					if($row->$column > $value) $arr[] = $row;
					break;
				case '<':
					if($row->$column < $value) $arr[] = $row;
					break;
				case '>=':
					if($row->$column >= $value) $arr[] = $row;
					break;
				case '<=':
					if($row->$column <= $value) $arr[] = $row;
					break;
			}
		}
		$this->temp = $arr;
		return $this;
	}
	
	public function insert($data) {
		if(count($data) != count($data, COUNT_RECURSIVE)) {
			for($i=0;$i<count($data);$i++) {
				array_push($this->arr, $data[$i]);
			}
		} else {
			array_push($this->arr, $data);
		}
		self::save();
		return $this;
	}
	
	public function insertAutoId($data) {	
		if(count($data) != count($data, COUNT_RECURSIVE)) {
			$max = 0;
			foreach($this->arr as $row) {
				if($row->id > $max) {
					$max = $row->id;
				}
			}
			for($i=0;$i<count($data);$i++) {
				$idarr = array('id' => $max+$i+1);
				$data[$i] = array_merge($idarr, $data[$i]);
					
				array_push($this->arr, $data[$i]);
			}
		} else {
			$max = 0;
			foreach($this->arr as $row) {
				if($row->id > $max) {
					$max = $row->id + 1;
				}
			}
			$idarr = array('id' => $max);
			$data = array_merge($idarr, $data);
			array_push($this->arr, $data);
		}
		self::save();
		return $this;
	}
	
	public function orderBy($column, $type) {
		$c = array();
		$temp = empty($this->temp) ? $this->arr : $this->temp;
		
		for($i=0;$i<count($temp)-1;$i++) {
			for($j=0;$j<count($temp)-1;$j++) {
				if($type=='desc') {
					if($temp[$j]->$column < $temp[$j+1]->$column) {
						$c = $temp[$j];
						$temp[$j] = $temp[$j+1];
						$temp[$j+1] = $c;
					}
				} elseif($type=='asc') {
					if($temp[$j]->$column > $temp[$j+1]->$column) {
						$c = $temp[$j];
						$temp[$j] = $temp[$j+1];
						$temp[$j+1] = $c;
					}
				}
			}
		}
		$this->temp = $temp;		
		return $this;
	}
	
	public function reorder($column) {
		$c = array();
		$temp = empty($this->temp) ? $this->arr : $this->temp;
		
		for($i=0;$i<count($this->arr)-1;$i++) {
			for($j=0;$j<count($this->arr)-1;$j++) {
				if($temp[$j]->$column > $temp[$j+1]->$column) {
					$c = $temp[$j];
					$temp[$j] = $temp[$j+1];
					$temp[$j+1] = $c;
				}
			}
		}
		$this->arr = $temp;
		self::save();
		self::__construct($this->name);
		return $this;
	}
	
	public function structure() {
		$temp = array_shift($this->arr);
		$a = array();
		foreach($temp as $key => $value) {
			$a[] = $key;
		}
		return $a;
	}
	
	public function limit($i) {
		$temp = empty($this->temp) ? $this->arr : $this->temp;
		$this->temp = array_slice($temp, 0, $i);
		return $this;
	}
	
	public function save() {
		$json = json_encode($this->arr, JSON_PRETTY_PRINT);
		file_put_contents($this->fullpath, $json);
	}
	
	public function delete() {
		foreach($this->temp as $key=>$value) {
			unset($this->arr[$key]);
			$this->arr = array_values($this->arr);
		}
		self::save();
		return $this;
	}
}

class BracketDB extends BracketConfig {

	public static function table($name) {
		$self = new BracketTable($name);
		return $self;
	}
	
	public static function create($name) {
		$data = json_encode(array());
		file_put_contents(dirname(__FILE__).parent::$path.$name.parent::$ext, $data);
	}
	
	public static function trash($name) {
		if(file_exists(dirname(__FILE__).parent::$path.$name.parent::$ext) && !file_exists(dirname(__FILE__)."/trash")) {
			mkdir(dirname(__FILE__)."/trash", 0777, true);
		}
		rename(dirname(__FILE__).parent::$path.$name.parent::$ext, dirname(__FILE__)."/trash/".$name);
	}
	
	public static function restore($name) {
		rename(dirname(__FILE__)."/trash/".$name, dirname(__FILE__).parent::$path.$name.parent::$ext);
	}
	
	public static function delete($name) {
		unlink(dirname(__FILE__).parent::$path.$name.parent::$ext);
	}
}


?>
