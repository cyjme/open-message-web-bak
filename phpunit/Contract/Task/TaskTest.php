<?php
namespace phpunit\Gap\Contract\Task;

use Gap\Contract\Task\Task;

class TaskTest extends \PHPUnit_Framework_TestCase
{
    public function testSealize()
    {
        $oldTask = new Task('taskName', ['k1' => 'v1', 'k2' => 'v2']);
        $json = json_encode([$oldTask->getName(), $oldTask->getCreated(), $oldTask->getAllAttrs()]);
        list($name, $created, $attrs) = json_decode($json, true);

        $newTask = new Task($name, $attrs);
        $newTask->setCreated($created);

        $this->assertEquals($newTask->getCreated(), $oldTask->getCreated());
        $this->assertEquals($newTask->getName(), $oldTask->getName());
        $this->assertEquals($newTask->getAllAttrs(), $oldTask->getAllAttrs());
    }
}
