<?php
/**
 * FormGenerator Example (https://github.com/lcharette/UF_FormGeneratorExample)
 *
 * @author Louis Charette
 * @link https://github.com/lcharette
 */
namespace UserFrosting\Sprinkle\FormGeneratorExample\Controller;

use Interop\Container\ContainerInterface;
use UserFrosting\Sprinkle\FormGenerator\RequestSchema;
use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\Fortress\Adapter\JqueryValidationAdapter;

/**
 * ProjectController Class
 *
 * Controller class for /projects/* URLs.
 */
class ProjectController {

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
    public function __construct(ContainerInterface $ci) {
        $this->ci = $ci;

        // For demo purpose
        $this->projects = collect([
            [
                "id" => 1,
                "name" => "Foo project",
                "description" => "The foo project is awesome, but not available.",
                "status" => 0
            ],
            [
                "id" => 2,
                "name" => "Bar project",
                "description" => "The bar project is less awesome, but at least it's open.",
                "status" => 1
            ]
        ]);
    }

    /**
     * mainList function.
     * Used to display a list of all the projects this user have access to or can manage
     *
     * @access public
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     * @return void
     */
    public function main($request, $response, $args){

        // Get a list of all projects
        // This should be a databse query. We hardcode it here for demo purposes
        //$projects = Project::all();
        $projects = $this->projects;

        $this->ci->view->render($response, 'pages/projects.twig', [
           "projects" => $projects
        ]);
    }

    /**
     * createForm function.
     * Renders the form for creating a new project.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
     * The form is rendered in "modal" (for popup) or "panel" mode, depending on the template used
     *
     * @access public
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     * @return void
     */
    public function createForm($request, $response, $args){

        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Request GET data
        $get = $request->getQueryParams();

        // Load validator rules
        $schema = new RequestSchema("schema://forms/project.json");
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        // Generate the form
        $schema->initForm();

        // Using custom form here to add the javascript we need fo Typeahead.
        $this->ci->view->render($response, "FormGenerator/modal.html.twig", [
            "box_id" => $get['box_id'],
            "box_title" => "Create project",
            "submit_button" => "Create",
            "form_action" => "/projects",
            "fields" => $schema->genereteForm(),
            "validators" => $validator->rules()
        ]);
    }

    /**
     * create function.
     * Processes the request to create a new project.
     *
     * @access public
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     * @return void
     */
    public function create($request, $response, $args){

        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Request POST data
        $post = $request->getParsedBody();

        // Load the request schema
        $schema = new RequestSchema("schema://forms/project.json");

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
        $ms->addMessageTranslated("success", "Project successfully created (or not)");
        return $response->withStatus(200);
    }

    /**
     * editForm function.
     * Renders the form for editing an existing project.
     *
     * This does NOT render a complete page.  Instead, it renders the HTML for the form, which can be embedded in other pages.
     * The form is rendered in "modal" (for popup) or "panel" mode, depending on the template used
     *
     * @access public
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     * @return void
     */
    public function editForm($request, $response, $args){

        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Request GET data
        $get = $request->getQueryParams();

        // Get the project to edit
        // This will typically be a databse query. We hardcode it here for demo purposes
        $project = $this->projects[$args['project_id'] - 1];

        // Load validator rules
        $schema = new RequestSchema("schema://forms/project.json");
        $validator = new JqueryValidationAdapter($schema, $this->ci->translator);

        // Generate the form
        $schema->initForm($project);

        // Render the template / form
        $this->ci->view->render($response, "FormGenerator/modal.html.twig", [
            "box_id" => $get['box_id'],
            "box_title" => "Edit project",
            "submit_button" => "Edit",
            "form_action" => "/projects/".$args['project_id'],
            "form_method" => "PUT", //Send form using PUT instead of "POST"
            "fields" => $schema->genereteForm(),
            "validators" => $validator->rules()
        ]);
    }

    /**
     * update function.
     * Processes the request to update an existing project's details.
     *
     * @access public
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     * @return void
     */
    public function update($request, $response, $args){

        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Get the target object
        $project_id = ($args['project_id']) ? $args['project_id'] : 0;
        $project = $this->projects[$project_id];

        // Request POST data
        $post = $request->getParsedBody();

        // Load the request schema
        $schema = new RequestSchema("schema://forms/project.json");

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
        $ms->addMessageTranslated("success", "Project successfully updated (or not)");
        return $response->withStatus(200);
    }


    /**
     * delete function.
     * Processes the request to delete an existing project.
     *
     * @access public
     * @param mixed $request
     * @param mixed $response
     * @param mixed $args
     * @return void
     */
    public function delete($request, $response, $args){

        // Get the alert message stream
        $ms = $this->ci->alerts;

        // Delete the project
        // This is where you would delete the project from the database

        // Nice and simple message
        $ms->addMessageTranslated("success", "Project successfully deleted (or not)");
        return $response->withStatus(200);
    }
}
