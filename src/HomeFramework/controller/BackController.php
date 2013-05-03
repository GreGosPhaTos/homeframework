<?php
namespace HomeFramework\controller;


abstract class BackController {
    /**
     * @var string
     */
    protected $action = '';

    /**
     * @var string
     */
    protected $module = '';

    /**
     * @var string
     */
    protected $view = '';

    /**
     * @var
     */
    protected $container;


    /**
     * @param \HomeFramework\container $container
     * @param $module
     * @param $action
     */
    public function __construct(\HomeFramework\container $container, $module, $action) {
        $this->setContainer($container);
        $this->page = $container->get('Page');
        $this->setModule($module);
        $this->setAction($action);
        $this->setView($action);
    }

    /**
     * @throws \RuntimeException
     */
    public function execute() {
        $method = 'execute'.ucfirst($this->action);

        if (!is_callable(array($this, $method))) {
            throw new \RuntimeException('L\'action "'.$this->action.'" n\'est pas définie sur ce module');
        }

        $this->$method();
    }

    /**
     * @param $module
     * @throws \InvalidArgumentException
     */
    public function setModule($module) {
        if (!is_string($module) || empty($module)) {
            throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
        }

        $this->module = $module;
    }

    /**
     * @param $container
     */
    public function setContainer($container) {
        $this->container = $container;
    }

    /**
     * @param $action
     * @throws \InvalidArgumentException
     */
    public function setAction($action) {
        if (!is_string($action) || empty($action)) {
            throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
        }

        $this->action = $action;
    }

    /**
     * @param $view
     * @throws \InvalidArgumentException
     */
    public function setView($view) {
        if (!is_string($view) || empty($view)) {
            throw new \InvalidArgumentException('La vue doit être une chaine de caractères valide');
        }

        $this->view = $view;
        $this->page->setContentFile(dirname(__FILE__).'/../Applications/'.$this->app->name().'/Modules/'.$this->module.'/Views/'.$this->view.'.php');
    }
}