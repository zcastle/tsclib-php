# zcastle/tsclib-php

Libreria para imprimir en las Etiquetadora TSC
> En desarrollo.

# Instalación
```bash
composer require "zcastle/tsclib-php @dev"
```

# Uso
```bash
use Zcastle\Lib\NetworkPrintConnector;
use Zcastle\Lib\TscLib;
use Zcastle\Lib\C;

$connector = new NetworkPrintConnector("192.168.2.23", 9100);
$tscLib = new TscLib($connector);

$tscLib->setup(53, 27, 5, 5, 0, 2, 0);
$tscLib->clearBuffer();

$tscLib->printerFont(212, 20, C::FONT_5, C::ROTATION_0, 1, 1, C::ALIGN_LEFT, "R2D2");
$tscLib->barCode(212, 84, "128", 72, C::HUMAN_READABLE_ALIGN_CENTER, 0, 2, 0, C::ALIGN_CENTER, "T2414365037");

$tscLib->printLabel();
$tscLib->close();
```

# Configuracion
```bash
setup($width, $height, $speed, $density, $sensor, $sensor_distance, $sensor_offset)
printerFont($x, $y, $size, $rotation, $x_value, $y_value, $align, $string)
barCode($x, $y, $type, $height, $human_readable, $rotation, $narrow, $wide, $align, $string)
bar($x, $y, $width, $height)
printLabel($quantity = 1, $copy = 1)
```
