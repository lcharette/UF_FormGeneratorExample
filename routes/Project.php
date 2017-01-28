<?php
/**
 * FormGenerator Example (https://github.com/lcharette/UF_FormGeneratorExample)
 *
 * @author Louis Charette
 * @link https://github.com/lcharette
 */

$app->group('/projects', function () {

    /* LIST */
    $this->get('', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\ProjectController:main');

    /* CREATE */
    $this->get('/new', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\ProjectController:createForm');
    $this->post('', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\ProjectController:create');

    /* EDIT */
    $this->get('/{project_id:[0-9]+}/edit', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\ProjectController:editForm');
    $this->put('/{project_id:[0-9]+}', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\ProjectController:update');

    /* DELETE */
    $this->delete('/{project_id:[0-9]+}', 'UserFrosting\Sprinkle\FormGeneratorExample\Controller\ProjectController:delete');
});