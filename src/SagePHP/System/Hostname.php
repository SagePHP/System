<?php

namespace SagePHP\System;
/**
 * helper class handle getting/setting hostname
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 */
class Hostname
{
    private $exec;

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
     * returns the current hostname
     *
     * @return string
     */
    public function get()
    {
        $exec = $this->getExecutor();

        $exec->setCommand('hostname');
        $exec->run();

        $output = $exec->getOutput();

        return $output['stdout'];
    }

    /**
     * sets the hostname
     *
     * @param string $name
     *
     * @return boolean true on success falsr otherwise
     */
    public function set($name)
    {
        $exec = $this->getExecutor();
        $exec->setCommand('hostname ' . $name);
        $exec->run();

        return $exec->hasErrors();
    }
}