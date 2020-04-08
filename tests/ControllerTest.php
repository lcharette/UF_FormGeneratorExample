<?php

/*
 * Form Generator Example
 *
 * @link      https://github.com/lcharette/UF_FormGeneratorExample
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_FormGeneratorExample/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\FormGenerator\Tests\Unit;

use UserFrosting\Sprinkle\Core\Tests\withController;
use UserFrosting\Sprinkle\FormGeneratorExample\Controller\FormGeneratorExampleController;
use UserFrosting\Tests\TestCase;

/**
 * ControllerTest
 * The FormGeneratorExample unit tests for supplied controllers.
 */
class ControllerTest extends TestCase
{
    use withController;

    /**
     * @return FormGeneratorExampleController
     */
    public function testConstructor(): FormGeneratorExampleController
    {
        $controller = new FormGeneratorExampleController($this->ci);
        $this->assertInstanceOf(FormGeneratorExampleController::class, $controller);

        return $controller;
    }

    /**
     * @depends testConstructor
     * @param FormGeneratorController $controller
     */
    /*public function testConfirm(FormGeneratorController $controller): void
    {
        $request = $this->getRequest();
        $result = $this->getResponse();
        $args = [];
        $controller->confirm($request, $result, $args);

        // Perform asertions
        $body = (string) $result->getBody();
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertNotSame('', $body);
    }*/
}
