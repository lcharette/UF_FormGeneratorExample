<?php

/*
 * Form Generator Example
 *
 * @link      https://github.com/lcharette/UF_FormGeneratorExample
 * @copyright Copyright (c) 2020 Louis Charette
 * @license   https://github.com/lcharette/UF_FormGeneratorExample/blob/master/LICENSE (MIT License)
 */

namespace UserFrosting\Sprinkle\FormGeneratorExample\Controller;

use Interop\Container\ContainerInterface;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\Sprinkle\FormGenerator\Form;

/**
 * ProjectController Class.
 *
 * Controller class for /formgenerator/* URLs.
 */
class FormGeneratorExampleController
{
    /**
     * @var ContainerInterface The global container object, which holds all your services.
     */
    protected $ci;

    protected $projects;

    /**
     * Create a new ProjectController object.
     *
     * @param ContainerInterface $ci The main UserFrosting app.
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->ci = $ci;

        // For demo purpose
        $this->projects = collect([
            [
                'id'          => 1,
                'name'        => 'Foo project',
                'owner'       => 'Foo',
                'description' => 'The foo project is awesome, but not available.',
                'status'      => 0,
                'completion'  => 100,
                'active'      => false,
            ],
            [
                'id'           => 2,
                'name'         => 'Bar project',
                'owner'        => '',
                'description'  => "The bar project is less awesome, but at least it's open.",
                'status'       => 1,
                'hiddenString' => 'The Bar secret code is...',
                'completion'   => 12,
                'active'       => true,
            ],
        ]);
    }

    /**
     * mainList function.
     * Used to display a list of all the projects this user have access to or can manage.
     *
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     */
    public function main($request, $response, $args)
    {

        // Get a list of all projects
        // This should be a databse query. We hardcode it here for demo purposes
        //$projects = Project::all();
        $projects = $this->projects;

        $this->ci->view->render($response, 'pages/formgenerator.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * createForm function.
     * Renders the form for creating a new project.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
     * The form is rendered in "modal" (for popup) or "panel" mode, depending on the template used
     *
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     */
    public function createForm($request, $response, $args)
    {

        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Request GET data
        $get = $request->getQueryParams();

        // Load validator rules
        $schema = new RequestSchema('schema://forms/formgenerator.json');
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        // Generate the form
        $form = new Form($schema);

        // Using custom form here to add the javascript we need fo Typeahead.
        $this->ci->view->render($response, 'FormGenerator/modal.html.twig', [
            'box_id'        => $get['box_id'],
            'box_title'     => 'Create project',
            'submit_button' => 'Create',
            'form_action'   => '/formgenerator',
            'fields'        => $form->generate(),
            'validators'    => $validator->rules('json', true),
        ]);
    }

    /**
     * create function.
     * Processes the request to create a new project.
     *
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     */
    public function create($request, $response, $args)
    {

        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Request POST data
        $post = $request->getParsedBody();

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
        // This is where the project would be saved to the database
        //$project = ...

        // Success message
        $ms->addMessageTranslated('success', 'Project successfully created (or not)');
        $ms->addMessageTranslated('info', 'The form data: <br />' . print_r($data, true));

        return $response->withJson([], 200, JSON_PRETTY_PRINT);
    }

    /**
     * editForm function.
     * Renders the form for editing an existing project.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
     * The form is rendered in "modal" (for popup) or "panel" mode, depending on the template used
     *
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     */
    public function editForm($request, $response, $args)
    {

        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Request GET data
        $get = $request->getQueryParams();

        // Get the project to edit
        // This will typically be a databse query. We hardcode it here for demo purposes
        $project = $this->projects[$args['project_id'] - 1];

        // Load validator rules
        $schema = new RequestSchema('schema://forms/formgenerator.json');
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        // Generate the form
        $form = new Form($schema, $project);

        // Render the template / form
        $this->ci->view->render($response, 'FormGenerator/modal.html.twig', [
            'box_id'        => $get['box_id'],
            'box_title'     => 'Edit project',
            'submit_button' => 'Edit',
            'form_action'   => '/formgenerator/' . $args['project_id'],
            'form_method'   => 'PUT', //Send form using PUT instead of "POST"
            'fields'        => $form->generate(),
            'validators'    => $validator->rules('json', true),
        ]);
    }

    /**
     * update function.
     * Processes the request to update an existing project's details.
     *
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     */
    public function update($request, $response, $args)
    {

        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Get the target object
        $project_id = ($args['project_id']) ? $args['project_id'] : 0;
        $project = $this->projects[$project_id];

        // Request POST data
        $post = $request->getParsedBody();

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

        //Success message!
        $ms->addMessageTranslated('success', 'Project successfully updated (or not)');
        $ms->addMessageTranslated('info', 'The form data: <br />' . print_r($data, true));

        return $response->withJson([], 200, JSON_PRETTY_PRINT);
    }

    /**
     * delete function.
     * Processes the request to delete an existing project.
     *
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     */
    public function delete($request, $response, $args)
    {

        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Delete the project
        // This is where you would delete the project from the database

        // Nice and simple message
        $ms->addMessageTranslated('success', 'Project successfully deleted (or not)');

        return $response->withJson([], 200, JSON_PRETTY_PRINT);
    }
}
