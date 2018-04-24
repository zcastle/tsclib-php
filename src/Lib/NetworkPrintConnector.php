<?php

namespace Zcastle\Lib;

use Zcastle\Lib\FilePrintConnector;

class NetworkPrintConnector extends FilePrintConnector {

	public function __construct($ip, $port = "9100") {
		$this->fp = @fsockopen($ip, $port, $errno, $errstr);
		if($this->fp === false) {
			throw new Exception("No se puede inicializar NetworkPrintConnector: " . $errstr);
		}
	}

}
