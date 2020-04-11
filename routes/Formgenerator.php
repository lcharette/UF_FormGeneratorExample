<?php

/*
 * Form Generator Example
 *
 * @link      https://github.com/lcharette/UF_FormGeneratorExample
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_FormGeneratorExample/blob/master/LICENSE (MIT License)
 */

use UserFrosting\Sprinkle\FormGeneratorExample\Controller\FormGeneratorExampleController;

$app->group('/formgenerator', function () {

    /* LIST */
    $this->get('', FormGeneratorExampleController::class . ':main')->setName('FG.main');

    /* CREATE */
    $this->get('/new', FormGeneratorExampleController::class . ':createForm')->setName('FG.createForm');
    $this->post('', FormGeneratorExampleController::class . ':create')->setName('FG.create');

    /* EDIT */
    $this->get('/{project_id:[0-9]+}/edit', FormGeneratorExampleController::class . ':editForm')->setName('FG.editForm');
    $this->put('/{project_id:[0-9]+}', FormGeneratorExampleController::class . ':update')->setName('FG.update');

    /* DELETE */
    $this->delete('/{project_id:[0-9]+}', FormGeneratorExampleController::class . ':delete')->setName('FG.delete');
})->add('authGuard');
