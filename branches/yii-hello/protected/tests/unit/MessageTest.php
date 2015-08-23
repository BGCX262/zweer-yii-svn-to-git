<?php

Yii::import('application.controllers.MessageController');

class MessageTest extends CTestCase
{
    public function testRepeat()
    {
        $message = new MessageController('messageTest');
        $this->assertEquals($message->repeat("Hello, Any One Out There?"), "Hello, Any One Out There?");
    }
}