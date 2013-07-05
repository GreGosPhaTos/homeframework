<?php
namespace HomeFramework\routing;

class Route
{

    /**
     * The action in Controller
     *
     * @var $action
     */
    protected $action;

    protected $module;

    protected $url;

    protected $vars = array();

    /**
     * Returns if vars is empty
     *
     * @return bool
     */
    public function hasVars() {
        return !empty($this->varsNames);
    }

    /**
     * @param $action
     */
    public function setAction($action) {
        if(is_string($action)) {
            $this->action = $action;
        }
    }

    /**
     * @param $module
     */
    public function setModule($module) {
        if(is_string($module)) {
            $this->module = $module;
        }
    }

    /**
     * @param $url
     */
    public function setUrl($url) {
        if(is_string($url)) {
            $this->url = $url;
        }
    }

    /**
     * @param array $vars
     */
    public function setVars(array $vars) {
        $this->vars = $vars;
    }

    /**
     * @return mixed
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getModule() {
        return $this->module;
    }

    /**
     * @return array
     */
    public function getVars() {
        return $this->vars;
    }
}