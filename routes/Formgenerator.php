<?php
/**
 * FormGenerator Example (https://github.com/lcharette/UF_FormGeneratorExample)
 *
 * @author Louis Charette
 * @link https://github.com/lcharette
 */

$app->group('/formgenerator', function () {

    /* LIST */
    $this->get('', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\FormGeneratorExampleController:main');

    /* CREATE */
    $this->get('/new', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\FormGeneratorExampleController:createForm');
    $this->post('', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\FormGeneratorExampleController:create');

    /* EDIT */
    $this->get('/{project_id:[0-9]+}/edit', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\FormGeneratorExampleController:editForm');
    $this->put('/{project_id:[0-9]+}', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\FormGeneratorExampleController:update');

    /* DELETE */
    $this->delete('/{project_id:[0-9]+}', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\FormGeneratorExampleController:delete');
});