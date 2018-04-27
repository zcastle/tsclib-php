<?php

namespace Zcastle\Lib;

use Zcastle\Lib\FilePrintConnector;

class NetworkPrintConnector extends FilePrintConnector {

	private $ip;
	private $port;

	public function __construct($ip, $port = "9100") {
		$this->ip = $ip;
		$this->port = $port;
		$this->fp = @fsockopen($ip, $port, $errno, $errstr, 30);
		if($this->fp === false) {
			throw new Exception("No se puede inicializar NetworkPrintConnector: " . $errstr);
		}
	}

	public function getIp(){
		return $this->ip;
	}

	public function getPort(){
		return $this->port;
	}

}
