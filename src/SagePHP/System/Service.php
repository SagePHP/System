<?php

namespace SagePHP\System;
/**
 * helper class handle services (system daemons)
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 */
class Service
{
    private $initPath;
    private $service;
    private $exec = null;

    public function __construct($service = null)
    {
        $this->setService($service);
    }

    /**
     * sets the class that will execute the command
     *
     * @param Exec $exec
     */
    public function setExecutor(Exec $exec)
    {
        $this->exec = $exec;
    }

    /**
     * gets the class that will execute the command
     *
     * @return Exec
     */
    public function getExecutor()
    {
        if (null === $this->exec) {
            $this->exec = new Exec;
        }

        return $this->exec;
    }

    /**
     * gets the full path to the service daemon
     *
     * @return string
     */
    private function getServicePath()
    {

        return str_replace('//', '/', implode(DIRECTORY_SEPARATOR, array($this->getInitPath(), $this->getService())));
    }

    /**
     * gets the helper command class
     *
     * @return Command
     */
    private function getCommand()
    {
        $command = new Command;
        $command->binary($this->getServicePath());

        return $command;
    }

    /**
     * Gets the value of initPath.
     *
     * @return mixed
     */
    public function getInitPath()
    {
        return $this->initPath;
    }

    /**
     * Sets the value of initPath.
     *
     * @param mixed $initPath the init path
     *
     * @return self
     */
    public function setInitPath($initPath)
    {
        $this->initPath = $initPath;

        return $this;
    }

    /**
     * Gets the value of service.
     *
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Sets the value of service.
     *
     * @param mixed $service the service
     *
     * @return self
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    private function execute(Command $command)
    {
        $exec =  $this->getExecutor();
        $exec->setCommand($command);
        $exec->run();

        return $exec;
    }

    private function run($what)
    {
        $command = $this->getCommand();
        $command->argument($what);

        return $this->execute($command);
    }

    public function start()
    {
        return $this->run('start');
    }

    public function stop()
    {
        return $this->run('stop');
    }

    public function restart()
    {
        return $this->run('restart');
    }
}