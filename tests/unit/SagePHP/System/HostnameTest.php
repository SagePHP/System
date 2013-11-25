<?php

namespace SagePHP\Test;

use SagePHP\System\Hostname;

class HostnameTest extends \PHPUnit_Framework_TestCase
{
    private function getExecMock()
    {
        $exec = $this->getMock('SagePHP\System\Exec');
        $exec->setProcessExecutor($this->getMock('Symfony\Component\Process\Process', array(), array('')));

        return $exec;
    }

    public function testGet()
    {
        $exec = $this->getExecMock();
        $exec
            ->expects($this->once())
            ->method('run');

        $exec
            ->expects($this->once())
            ->method('setCommand')
            ->with($this->equalTo('hostname'));

        $exec
            ->expects($this->once())
            ->method('getOutput')
            ->will($this->returnValue(array('stdout'=>'localhost')));

        $host = new Hostname;
        $host->setExecutor($exec);
        $hostname = $host->get();
        $this->assertEquals('localhost', $hostname);
    }


    public function testSet()
    {
        $exec = $this->getExecMock();
        $exec
            ->expects($this->once())
            ->method('run');

        $exec
            ->expects($this->once())
            ->method('setCommand')
            ->with($this->equalTo('hostname localhost.local'));


        $host = new Hostname;
        $host->setExecutor($exec);
        $host->set('localhost.local');
    }


}
