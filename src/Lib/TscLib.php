<?php

namespace Zcastle\Lib;

class TscLib {

	const ALIGN_LEFT = 1;
    const ALIGN_CENTER = 2;
    const ALIGN_RIGHT = 3;

    const HUMAN_NO_READABLE = 0;
    const HUMAN_READABLE_ALIGN_LEFT = 1;
    const HUMAN_READABLE_ALIGN_CENTER = 2;
    const HUMAN_READABLE_ALIGN_RIGHT = 3;

	private $connector = null;

	public function __construct(PrintConnector $connector = null) {
		$this->connector = $connector;

		return $this;
	}

	public function setup($width, $height, $speed, $density, $sensor, $sensor_distance, $sensor_offset){
		if($this->connector == null){
			throw new Exception("No esta conectado", 1);
		}

        $size = "SIZE " . $width . " mm" . ", " . $height . " mm";
        $speed_value = "SPEED " . $speed;
        $density_value = "DENSITY " . $density;

        $sensor_value = "";
        if ($sensor == 0) {
            $sensor_value = "GAP " . $sensor_distance . " mm" . ", " . $sensor_offset . " mm";
        } else if ($sensor == 1) {
            $sensor_value = "BLINE " . $sensor_distance . " mm" . ", " . $sensor_offset . " mm";
        }

        $message = $size . "\r\n" . $speed_value . "\r\n" . $density_value . "\r\n" . $sensor_value . "\r\n";

		$this->connector->write($message);

		return $this;
	}

	public function clearbuffer(){
		if($this->connector == null){
			throw new Exception("No esta conectado", 1);
		}

		$this->connector->write("CLS\r\n");

		return $this;
	}

	public function printerfont($x, $y, $size, $rotation, $x_value, $y_value, $align, $string){
		if($this->connector == null){
			throw new Exception("No esta conectado", 1);
		}

        $text = "TEXT ";
        $position = $x . "," . $y;
        $size_value = "\"" . $size . "\"";
        $string_value = "\"" . $string . "\"";

        $message = $text . $position . " ," . $size_value . " ," . $rotation . " ," . $x_value . " ," . $y_value . " ," . $align . " ," . $string_value . "\r\n";

        $this->connector->write($message);

		return $this;
	}

	public function barcode($x, $y, $type, $height, $human_readable, $rotation, $narrow, $wide, $align, $string) {
        if($this->connector == null){
			throw new Exception("No esta conectado", 1);
		}

        $barcode = "BARCODE ";
        $position = $x . "," . $y;
        $mode = "\"" . $type . "\"";
        $string_value = "\"" . $string . "\"";

        $message = $barcode . $position . " ," . $mode . " ," . $height . " ," . $human_readable . " ," . $rotation . " ," . $narrow . " ," . $wide  . " ," . $align . " ," . $string_value . "\r\n";

        $this->connector->write($message);

		return $this;
    }

    public function bar($x, $y, $width, $height) {
        if($this->connector == null){
            throw new Exception("No esta conectado", 1);
        }

        $bar = "BAR " . $x . ", " . $y . ", " . $width . ", " . $height;

        $message = $bar . "\r\n";

        $this->connector->write($message);

        return $this;
    }

    public function sendCommand($message) {
        if($this->connector == null){
			throw new Exception("No esta conectado", 1);
		}
        
        $this->connector->write($message . "\n");

		return $this;
    }

    public function printlabel($quantity, $copy){
    	if($this->connector == null){
			throw new Exception("No esta conectado", 1);
		}

    	$this->connector->write("PRINT " . $quantity . ", " . $copy . "\r\n");
    }

    public function closeport(){
    	if($this->connector == null){
			throw new Exception("No esta conectado", 1);
		}

    	try {
            $this->connector->close();
        } catch (Exception $e) {
            return false;
        }
    }
}

?>