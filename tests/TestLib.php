<?php

//namespace Tests;

use PHPUnit\Framework\TestCase;

use Zcastle\Lib\NetworkPrintConnector;
use Zcastle\Lib\TscLib;

final class TestLib extends TestCase {

	public function test(){
		$ip = "192.168.2.23";
		$port = 9100;
		/*$connector = new NetworkPrintConnector("192.168.2.23", 9100);
		$tscLib = new TscLib($connector);
		$tscLib->setup(53, 27, 5, 5, 0, 2, 0);
		$tscLib->clearbuffer();

		$tscLib->printerfont(212, 20, "5", 0, 1, 1, TscLib::ALIGN_CENTER, "R2D2");
		$tscLib->barcode(212, 84, "128", 72, TscLib::HUMAN_READABLE_ALIGN_CENTER, 0, 2, 0, TscLib::ALIGN_CENTER, "T2414365037");

		$tscLib->printlabel(1, 1);

		$tscLib->closeport();*/

		$connector = new NetworkPrintConnector($ip, $port);
		$tscLib = new TscLib($connector);

		$estado = $tscLib->status();
		if($estado == TscLib::ESTADO_NORMAL){
			print_r("OK");
		} else {
			print_r($estado);
		}
		//$tscLib->sendCommand("\x1b!\x3f");
		//$tscLib->sendCommand("\x1b\x21\x3f");
		//$tscLib->sendCommand("\x1b" . "!" . chr(63));
		//
		//print_r($tscLib->getResponseCommand());

		//print_r(dirname(__FILE__));
		//print_r($tscLib->getPath());
	}

}

?>