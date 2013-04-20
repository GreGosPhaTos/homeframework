<?php
namespace HomeFramework\config;

class Configurator {
    /**
     *
     * @var \HomeFramework\formatter\IFormatter
     */
    private $formatter;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param \HomeFramework\formatter\IFormatter $formatter
     */
    public function __construct(\HomeFramework\formatter\IFormatter $formatter) {
        $this->formatter = $formatter;
        $this->config = new Config();
    }

    /**
     * @return Config
     */
    public function configure() {
        $configurations = $this->formatter->toArray();

        foreach ($configurations as $name => $configuration) {
            $this->config->set($name, $configuration);
        }

        return $this->config;
    }
}