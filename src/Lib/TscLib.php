<?php

namespace Zcastle\Lib;

// TSPL/TSPL2 Programming Language

class TscLib {

    const ESTADO_NORMAL = "Normal";

	private $connector = null;
    private $responseCommand;

	public function __construct(PrintConnector $connector = null) {
		$this->connector = $connector;

		return $this;
	}

	public function setup($width, $height, $speed, $density, $sensor, $sensor_distance, $sensor_offset){
        $size = "SIZE " . $width . " mm" . ", " . $height . " mm";
        $speed_value = "SPEED " . $speed;
        $density_value = "DENSITY " . $density;

        $sensor_value = "";
        if ($sensor == 0) {
            $sensor_value = "GAP " . $sensor_distance . " mm" . ", " . $sensor_offset . " mm";
        } else if ($sensor == 1) {
            $sensor_value = "BLINE " . $sensor_distance . " mm" . ", " . $sensor_offset . " mm";
        }

        $message = $size . "\r\n" . $speed_value . "\r\n" . $density_value . "\r\n" . $sensor_value;

		return $this->sendCommand($message);
	}

	public function clearBuffer(){

		return $this->sendCommand("CLS");
	}

	public function printerFont($x, $y, $size, $rotation, $x_value, $y_value, $align, $string){

        $text = "TEXT ";
        $position = $x . "," . $y;
        $size_value = "\"" . $size . "\"";
        $string_value = "\"" . $string . "\"";

        $message = $text . $position . " ," . $size_value . " ," . $rotation . " ," . $x_value . " ," . $y_value . " ," . $align . " ," . $string_value;

        return $this->sendCommand($message);
	}

	public function barCode($x, $y, $type, $height, $human_readable, $rotation, $narrow, $wide, $align, $string) {

        $barcode = "BARCODE ";
        $position = $x . "," . $y;
        $mode = "\"" . $type . "\"";
        $string_value = "\"" . $string . "\"";

        $message = $barcode . $position . " ," . $mode . " ," . $height . " ," . $human_readable . " ," . $rotation . " ," . $narrow . " ," . $wide  . " ," . $align . " ," . $string_value;

        return $this->sendCommand($message);
    }

    public function bar($x, $y, $width, $height) {

        $message = "BAR " . $x . ", " . $y . ", " . $width . ", " . $height;

        return $this->sendCommand($message);
    }

    public function printLabel($quantity = 1, $copy = 1){

    	return $this->sendCommand("PRINT " . $quantity . ", " . $copy);
    }

    public function sendCommand($message) {
        if($this->connector == null){
            throw new Exception("No esta conectado", 1);
        }
        
        $this->connector->write($message . "\r\n");

        return $this;
    }

    public function close(){
    	if($this->connector == null){
			throw new Exception("No esta conectado", 1);
		}

    	try {
            $this->connector->close();
        } catch (Exception $e) {
            return false;
        }
    }

    public function getStatus(){
        $output = "No se ha podido consulta el estado";
        $ruta = dirname(__FILE__);
        $ip = $this->connector->getIp();
        $port = $this->connector->getPort();
        exec("cd $ruta && java TscStatus $ip $port", $output);
        return $output[0];
    }

}

?>