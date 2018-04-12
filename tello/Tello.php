<?php

namespace Tello;

class Tello
{

    const TELLO_IP = '192.168.10.1';
    const TELLO_PORT = 8889;

    protected $localhost;
    protected $localport;
    protected $socket;

    public function __construct($localhost = '192.168.10.2', $localport = 9000)
    {
        $this->localhost = $localhost;
        $this->localport = $localport;

        $this->preFlightSetup();
    }

    public function takeoff()
    {
        return $this->sendCommand('takeoff');
    }

    public function land()
    {
        return $this->sendCommand('land');
    }

    public function up($height = 20)
    {
        $height = $this->evaluateDistanceParam($height);

        return $this->sendCommand('up ' . $height);
    }

    public function down($height = 20)
    {
        $height = $this->evaluateDistanceParam($height);

        return $this->sendCommand('down ' . $height);
    }

    public function left($distance = 20)
    {
        $distance = $this->evaluateDistanceParam($distance);

        return $this->sendCommand('left ' . $distance);
    }

    public function right($distance = 20)
    {
        $distance = $this->evaluateDistanceParam($distance);

        return $this->sendCommand('right ' . $distance);
    }

    public function forward($distance = 20)
    {
        $distance = $this->evaluateDistanceParam($distance);

        return $this->sendCommand('forward ' . $distance);
    }

    public function back($distance = 20)
    {
        $distance = $this->evaluateDistanceParam($distance);

        return $this->sendCommand('back ' . $distance);
    }

    public function cw($angle = 1)
    {
        $angle = $this->evaluateAngleParam($angle);

        return $this->sendCommand('cw ' . $angle);
    }

    public function ccw($angle = 1)
    {
        $angle = $this->evaluateAngleParam($angle);

        return $this->sendCommand('ccw ' . $angle);
    }

    public function flip($direction)
    {
        return $this->sendCommand('flip ' . $direction);
    }

    public function setSpeed($speed)
    {
        $speed = intval($speed);

        if ($speed < 1) {
            $speed = 1;
        }

        if ($speed > 100) {
            $speed = 100;
        }

        return $this->sendCommand('speed ' . $speed);
    }

    public function readSpeed()
    {
        return $this->sendCommand('Speed?');
    }

    public function readBattery()
    {
        return $this->sendCommand('Battery?');
    }

    public function readTime()
    {
        return $this->sendCommand('Time?');
    }

    public function preFlightSetup()
    {
        $this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_bind($this->socket, $this->localhost, $this->localport);
        socket_connect($this->socket, self::TELLO_IP, self::TELLO_PORT);
        $this->sendCommand('command');
    }

    public function endFlight()
    {
        $land = $this->land();

        // if land ok, close socket
        if ($land = 1) {
            socket_close($this->socket);
            return true;
        }

        return false;
    }

    protected function sendCommand($command)
    {
        return socket_send($this->socket, $command, strlen($command), 0);
    }

    protected function evaluateDistanceParam($distance)
    {
        $distance = intval($distance);

        if ($distance < 20) {
            $distance = 20;
        }

        if ($distance > 500) {
            $distance = 500;
        }

        return $distance;
    }

    protected function evaluateAngleParam($angle)
    {
        $angle = intval($angle);

        if ($angle < 1) {
            $angle = 1;
        }

        if ($angle > 360) {
            $angle = 360;
        }

        return $angle;
    }

}