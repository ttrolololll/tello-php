<?php

require __DIR__.'/vendor/autoload.php';

$tello = new \Tello\Tello();

$tello->takeoff();

sleep(5);

$tello->up(50);

sleep(5);

$tello->down(50);

sleep(5);

$tello->left(50);

sleep(5);

$tello->right(50);

sleep(5);

$tello->forward(100);

sleep(5);

$tello->back(100);

sleep(5);

$tello->cw(90);

sleep(5);

$tello->ccw(90);

sleep(5);

$tello->land();