<?php

/*
 * Form Generator Example
 *
 * @link      https://github.com/lcharette/UF_FormGeneratorExample
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_FormGeneratorExample/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\FormGeneratorExample\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\Sprinkle\Core\Controller\SimpleController;
use UserFrosting\Sprinkle\FormGenerator\Form;
use UserFrosting\Sprinkle\FormGeneratorExample\Data\Project;
use UserFrosting\Support\Exception\NotFoundException;

/**
 * FormGeneratorExampleController Class.
 *
 * Controller class for /formgenerator/* URLs.
 */
class FormGeneratorExampleController extends SimpleController
{
    /**
     * Display a list of all the projects
     * Request type: GET.
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     */
    public function main(Request $request, Response $response, array $args): Response
    {
        // Get all projects
        // This can be replace by a database Model. We hardcode it here in the helper class for demo purposes.
        $projects = Project::all();

        return $this->ci->view->render($response, 'pages/formgenerator.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * Renders the form for creating a new project.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
     * The form is rendered in "modal" (for popup) or "panel" mode, depending on the template used
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     */
    public function createForm(Request $request, Response $response, array $args): Response
    {
        // Request GET data
        $get = $request->getQueryParams();

        // Load validator rules
        $schema = new RequestSchema('schema://forms/formgenerator.json');
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        // Generate the form
        $form = new Form($schema);

        // Using custom form here to add the javascript we need fo Typeahead.
        return $this->ci->view->render($response, 'FormGenerator/modal.html.twig', [
            'box_id'        => $get['box_id'],
            'box_title'     => 'Create project',
            'submit_button' => 'Create',
            'form_action'   => '/formgenerator',
            'fields'        => $form->generate(),
            'validators'    => $validator->rules('json', true),
        ]);
    }

    /**
     * Processes the request to create a new project.
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     */
    public function create(Request $request, Response $response, array $args): Response
    {
        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Request POST data
        $post = $request->getParsedBody() ?: [];

        // Load the request schema
        $schema = new RequestSchema('schema://forms/formgenerator.json');

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($post);

        // Validate, and halt on validation errors.
        $validator = new ServerSideValidator($schema, $this->ci->translator);
        if (!$validator->validate($data)) {
            $ms->addValidationErrors($validator);

            return $response->withStatus(400);
        }

        // Create the item.
        // This is where the project would be saved to the database.
        // This can be replace by a database Model.
        // $project = new Project($data);
        // $project->save();

        // Success message
        $ms->addMessageTranslated('success', 'Project successfully created (or not)');
        $ms->addMessageTranslated('info', 'The form data: <br />' . print_r($data, true));

        return $response->withJson([]);
    }

    /**
     * Renders the form for editing an existing project.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
     * The form is rendered in "modal" (for popup) or "panel" mode, depending on the template used
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     */
    public function editForm(Request $request, Response $response, array $args): Response
    {
        /** @var \UserFrosting\Sprinkle\Core\Router $router */
        $router = $this->ci->router;

        // Request GET data
        $get = $request->getQueryParams();

        // Get the project to edit.
        // This can be replace by a database Model. We hardcode it here in the helper class for demo purposes.
        $project = Project::find($args['project_id']);

        // Make sure a project was found.
        if (!$project) {
            throw new NotFoundException('Project not found');
        }

        // Load validator rules
        $schema = new RequestSchema('schema://forms/formgenerator.json');
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        // Generate the form
        $form = new Form($schema, $project);

        // Render the template / form
        return $this->ci->view->render($response, 'FormGenerator/modal.html.twig', [
            'box_id'        => $get['box_id'],
            'box_title'     => 'Edit project',
            'submit_button' => 'Edit',
            'form_action'   => $router->pathFor('FG.update', $args),
            'form_method'   => 'PUT', //Send form using PUT instead of "POST"
            'fields'        => $form->generate(),
            'validators'    => $validator->rules('json', true),
        ]);
    }

    /**
     * Processes the request to update an existing project's details.
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     */
    public function update(Request $request, Response $response, array $args): Response
    {
        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Get the target object & make sure a project was found.
        if (!$project = Project::find($args['project_id'])) {
            throw new NotFoundException('Project not found');
        }

        // Request POST data
        $post = $request->getParsedBody() ?: [];

        // Load the request schema
        $schema = new RequestSchema('schema://forms/formgenerator.json');

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($post);

        // Validate, and halt on validation errors.
        $validator = new ServerSideValidator($schema, $this->ci->translator);
        if (!$validator->validate($data)) {
            $ms->addValidationErrors($validator);

            return $response->withStatus(400);
        }

        // Update the project
        // This is where you would save the changes to the database...
        // $project->fill($data)->save();

        //Success message!
        $ms->addMessageTranslated('success', 'Project successfully updated (or not)');
        $ms->addMessageTranslated('info', 'The form data: <br />' . print_r($data, true));

        return $response->withJson([]);
    }

    /**
     * Processes the request to delete an existing project.
     *
     * @param Request  $request
     * @param Response $response
     * @param string[] $args
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Get the target object & make sure a project was found.
        if (!$project = Project::find($args['project_id'])) {
            throw new NotFoundException('Project not found');
        }

        // Delete the project
        // This is where you would delete the project from the database
        // $project->delete();

        // Nice and simple message
        $ms->addMessageTranslated('success', 'Project successfully deleted (or not)');

        return $response->withJson([]);
    }
}
