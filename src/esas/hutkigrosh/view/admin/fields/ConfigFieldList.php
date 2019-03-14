<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 10:29
 */

namespace esas\hutkigrosh\view\admin\fields;


class ConfigFieldList extends ConfigField
{
    /**
     * @var ListOption[]
     */
    private $options;

    /**
     * ConfigFieldList constructor.
     * @param array $options
     */
    public function __construct($key, $name = null, $description = null, $required = false, $options = null)
    {
        parent::__construct($key, $name, $description, $required);
        $this->options = $options;
    }

    /**
     * @return ListOption[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function addOption($key, $name)
    {
        $this->options[] = new ListOption($key, $name);
    }

    /**
     * @param ListOption[] $options
     * @return ConfigFieldList
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }


}