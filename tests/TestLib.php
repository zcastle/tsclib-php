<?php

//namespace Tests;

use PHPUnit\Framework\TestCase;

use Zcastle\Lib\NetworkPrintConnector;
use Zcastle\Lib\TscLib;
use Zcastle\Lib\C;

final class TestLib extends TestCase {

	public function test(){
		$ip = "192.168.2.23";
		$port = 9100;
		$connector = new NetworkPrintConnector("192.168.2.23", 9100);
		$tscLib = new TscLib($connector);
		$tscLib->setup(53, 27, 5, 5, 0, 2, 0);
		$tscLib->clearBuffer();

		$tscLib->printerFont(212, 20, C::FONT_5, C::ROTATION_0, 1, 1, C::ALIGN_CENTER, "R2D2");
		$tscLib->barCode(212, 84, "128", 72, C::HUMAN_READABLE_ALIGN_CENTER, 0, 2, 0, C::ALIGN_CENTER, "T2414365037");

		$tscLib->printLabel();

		$tscLib->close();

		/*$connector = new NetworkPrintConnector($ip, $port);
		$tscLib = new TscLib($connector);

		$estado = $tscLib->getStatus();
		if($estado == TscLib::ESTADO_NORMAL){
			print_r("OK");
		} else {
			print_r($estado);
		}*/
	}

}

?>