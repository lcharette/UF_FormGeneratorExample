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
use UserFrosting\Support\Exception\NotFoundException;
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
     * @param FormGeneratorExampleController $controller
     */
    public function testMain(FormGeneratorExampleController $controller): void
    {
        $request = $this->getRequest();

        $result = $controller->main($request, $this->getResponse(), []);

        // Perform asertions
        $body = (string) $result->getBody();
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertNotSame('', $body);
    }

    /**
     * @depends testConstructor
     * @param FormGeneratorExampleController $controller
     */
    public function testCreateForm(FormGeneratorExampleController $controller): void
    {
        $request = $this->getRequest()->withQueryParams([
            'box_id' => 'formGeneratorModal',
        ]);

        $result = $controller->createForm($request, $this->getResponse(), []);

        // Perform asertions
        $body = (string) $result->getBody();
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertNotSame('', $body);
    }

    /**
     * @depends testConstructor
     * @param FormGeneratorExampleController $controller
     */
    public function testCreate(FormGeneratorExampleController $controller): void
    {
        $data = [
            'name'       => 'Foo',
            'status'     => '1',
            'completion' => '50',
        ];

        $request = $this->getRequest()->withParsedBody($data);

        $result = $controller->create($request, $this->getResponse(), []);

        // Perform asertions
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertJson((string) $result->getBody());
        $this->assertSame('[]', (string) $result->getBody());

        // Test alert message
        $ms = $this->ci->alerts;
        $messages = $ms->getAndClearMessages();
        $this->assertSame('info', end($messages)['type']);
        $this->assertStringContainsString(print_r($data, true), end($messages)['message']);
    }

    /**
     * @depends testConstructor
     * @param FormGeneratorExampleController $controller
     */
    public function testCreateForFailValidation(FormGeneratorExampleController $controller): void
    {
        $request = $this->getRequest()->withParsedBody([
            //'name'       => 'Foo',
            'status'     => '1',
            'completion' => '50',
        ]);

        $result = $controller->create($request, $this->getResponse(), []);

        // Perform asertions
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 400);
        $this->assertSame('', (string) $result->getBody());

        // Test alert message
        $ms = $this->ci->alerts;
        $messages = $ms->getAndClearMessages();
        $this->assertSame('danger', end($messages)['type']);
        $this->assertSame('Please specify a value for <strong>Project name</strong>.', end($messages)['message']);
    }

    /**
     * @depends testConstructor
     * @param FormGeneratorExampleController $controller
     */
    public function testEditForm(FormGeneratorExampleController $controller): void
    {
        $request = $this->getRequest()->withQueryParams([
            'box_id' => 'formGeneratorModal',
        ]);

        $result = $controller->editForm($request, $this->getResponse(), ['project_id' => 1]);

        // Perform asertions
        $body = (string) $result->getBody();
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertNotSame('', $body);
    }

    /**
     * @depends testConstructor
     * @param FormGeneratorExampleController $controller
     */
    public function testEditFormForProjectNotFound(FormGeneratorExampleController $controller): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Project not found');
        $controller->editForm($this->getRequest(), $this->getResponse(), ['project_id' => 123]);
    }

    /**
     * @depends testConstructor
     * @param FormGeneratorExampleController $controller
     */
    public function testUpdate(FormGeneratorExampleController $controller): void
    {
        $data = [
            'name'       => 'Foo',
            'status'     => '1',
            'completion' => '50',
        ];

        $request = $this->getRequest()->withParsedBody($data);

        $result = $controller->update($request, $this->getResponse(), ['project_id' => 1]);

        // Perform asertions
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertJson((string) $result->getBody());
        $this->assertSame('[]', (string) $result->getBody());

        // Test alert message
        $ms = $this->ci->alerts;
        $messages = $ms->getAndClearMessages();
        $this->assertSame('info', end($messages)['type']);
        $this->assertStringContainsString(print_r($data, true), end($messages)['message']);
    }

    /**
     * @depends testConstructor
     * @param FormGeneratorExampleController $controller
     */
    public function testUpdateForFailedValidation(FormGeneratorExampleController $controller): void
    {
        $data = [
            //'name'       => 'Foo',
            'status'     => '1',
            'completion' => '50',
        ];

        $request = $this->getRequest()->withParsedBody($data);

        $result = $controller->update($request, $this->getResponse(), ['project_id' => 1]);

        // Perform asertions
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 400);
        $this->assertSame('', (string) $result->getBody());

        // Test alert message
        $ms = $this->ci->alerts;
        $messages = $ms->getAndClearMessages();
        $this->assertSame('danger', end($messages)['type']);
        $this->assertSame('Please specify a value for <strong>Project name</strong>.', end($messages)['message']);
    }

    /**
     * @depends testConstructor
     * @param FormGeneratorExampleController $controller
     */
    public function testUdateForProjectNotFound(FormGeneratorExampleController $controller): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Project not found');
        $controller->update($this->getRequest(), $this->getResponse(), ['project_id' => 123]);
    }

    /**
     * @depends testConstructor
     * @param FormGeneratorExampleController $controller
     */
    public function testDelete(FormGeneratorExampleController $controller): void
    {
        $result = $controller->delete($this->getRequest(), $this->getResponse(), ['project_id' => 1]);

        // Perform asertions
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $result);
        $this->assertSame($result->getStatusCode(), 200);
        $this->assertJson((string) $result->getBody());
        $this->assertSame('[]', (string) $result->getBody());

        // Test alert message
        $ms = $this->ci->alerts;
        $messages = $ms->getAndClearMessages();
        $this->assertSame('success', end($messages)['type']);
        $this->assertSame('Project successfully deleted (or not)', end($messages)['message']);
    }

    /**
     * @depends testConstructor
     * @param FormGeneratorExampleController $controller
     */
    public function testDeleteForProjectNotFound(FormGeneratorExampleController $controller): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Project not found');
        $controller->delete($this->getRequest(), $this->getResponse(), ['project_id' => 123]);
    }
}
