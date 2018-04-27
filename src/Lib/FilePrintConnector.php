<?php

namespace Zcastle\Lib;

use Zcastle\Lib\PrintConnector;

class FilePrintConnector implements PrintConnector {

	protected $fp;

	public function __construct($filename) {
		$this->fp = fopen($filename, "wb+");
		if($this->fp === false) {
			throw new Exception("No se puede inicializar FilePrintConnector.");
		}
	}

	public function close() {
		fclose($this->fp);
		$this->fp = false;
	}
	
	public function write($data) {
		fwrite($this->fp, $data);
		//return stream_get_contents($this->fp);
		/*$a = [];
		while ($line = fgets($fp)){
		}*/
		//return fgets($this->fp);
	}

	public function getFp(){
		return $this->fp;
	}
}
