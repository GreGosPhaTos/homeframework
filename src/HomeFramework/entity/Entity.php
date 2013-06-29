<?php
abstract class Entity implements \ArrayAccess {

    /**
     * @var
     */
    protected $id;

    /**
     * @var array
     */
    private $data = array();

    /**
     * @param array $data
     * @throws InvalidArgumentException
     */
    public function __construct(array $data) {
        if (empty($data)) {
            throw new \InvalidArgumentException("Array Data is empty.");
        }

        $this->data = $data;
        $this->hydrate();
    }

    /**
     * @return bool
     */
    public function isNew() {
        return empty($this->id);
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id) {
        $this->id = (int) $id;
    }

    /**
     *
     */
    public function hydrate() {
        foreach ($this->data as $attribute => $value) {
            $method = 'set'.ucfirst($attribute);

            if (is_callable(array($this, $method))) {
                $this->$method($value);
            }
        }
    }

    /**
     * @param mixed $var
     * @return mixed
     */
    public function offsetGet($var) {
        if (isset($this->$var) && is_callable(array($this, $var))) {
            return $this->$var();
        }
    }

    /**
     * @param mixed $var
     * @param mixed $value
     */
    public function offsetSet($var, $value) {
        $method = 'set'.ucfirst($var);

        if (isset($this->$var) && is_callable(array($this, $method))) {
            $this->$method($value);
        }
    }

    /**
     * @param mixed $var
     * @return bool
     */
    public function offsetExists($var) {
        return isset($this->$var) && is_callable(array($this, $var));
    }

    /**
     * @param mixed $var
     * @throws Exception
     */
    public function offsetUnset($var) {
        throw new \Exception('Impossible de supprimer une quelconque valeur');
    }
}