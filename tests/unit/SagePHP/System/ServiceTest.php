<?php

namespace SagePHP\Test;

use SagePHP\System\Service;

class ServiceTest extends \PHPUnit_Framework_TestCase
{
    private function getExecMock()
    {
        $exec = $this->getMock('SagePHP\System\Exec', array('run'));
        $exec->expects($this->once())
            ->method('run');
        $exec->setProcessExecutor($this->getMock('Symfony\Component\Process\Process', array(), array('')));

        return $exec;
    }
    public function testExec()
    {
        $service = new Service('service');
        $service->setExecutor($this->getExecMock());
        $service->setInitPath('/ini/path/');

        $systemCommand = $service->start();

        $command = $systemCommand->getCommand();

        $this->assertEquals('/ini/path/service start', (string) $command);


    }
}
