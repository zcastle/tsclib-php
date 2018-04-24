<?php

namespace Zcastle\Lib;

interface PrintConnector {
	
	public function close();

	public function write($data);
}
