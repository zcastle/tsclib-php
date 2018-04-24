<?php

//namespace Tests;

use PHPUnit\Framework\TestCase;

use Zcastle\Lib\NetworkPrintConnector;
use Zcastle\Lib\TscLib;

final class TestLib extends TestCase {

	public function test(){
		$connector = new NetworkPrintConnector("192.168.2.23", 9100);
		$tscLib = new TscLib($connector);
		$tscLib->setup(53, 27, 5, 5, 0, 2, 0);
		$tscLib->clearbuffer();

		$tscLib->printerfont(212, 20, "5", 0, 1, 1, TscLib::ALIGN_CENTER, "R2D2");
		$tscLib->barcode(212, 84, "128", 72, TscLib::HUMAN_READABLE_ALIGN_CENTER, 0, 2, 0, TscLib::ALIGN_CENTER, "T2414365037");

		$tscLib->printlabel(1, 1);

		$tscLib->closeport();
	}

}

?>