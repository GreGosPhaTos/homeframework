<?php
namespace HomeFramework\manager;

class EntityManager {

    /**
     * @var
     */
    protected $api;

    /**
     * @var
     */
    protected $dao;

    /**
     * @var array
     */
    protected $managers = array();

    /**
     * @param $api
     * @param $dao
     */
    public function __construct($api, $dao) {
        $this->api = $api;
        $this->dao = $dao;
    }

    /**
     * @param $module
     * @throws \Exception
     * @return mixed
     */
    public function getManagerOf($module) {
        if (!isset($this->managers[$module])) {
            $manager = "\\".$module."\\models\\"."Manager_".$this->api;
            if (!class_exists($manager)) {
                throw new \Exception("Entity manager the class " . $manager ."  not found");
            }
            $this->managers[$module] = new $manager($this->dao);
        }

        return $this->managers[$module];
    }
}