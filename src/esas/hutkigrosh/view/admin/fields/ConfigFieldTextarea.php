<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 01.10.2018
 * Time: 10:29
 */

namespace esas\hutkigrosh\view\admin\fields;


use esas\hutkigrosh\view\admin\validators\Validator;

class ConfigFieldTextarea extends ConfigFieldText
{
    private $cols;
    private $rows;

    /**
     * ConfigFieldNumber constructor.
     * @param $min
     * @param $max
     */
    public function __construct($key, $name = null, $description = null, $required = false, Validator $validator = null, $cols = 20, $rows = 8)
    {
        parent::__construct($key, $name, $description, $required, $validator);
        $this->cols = $cols;
        $this->rows = $rows;
    }

    /**
     * @return int
     */
    public function getCols()
    {
        return $this->cols;
    }

    /**
     * @param int $cols
     * @return ConfigFieldTextarea
     */
    public function setCols($cols)
    {
        $this->cols = $cols;
        return $this;
    }

    /**
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param int $rows
     * @return ConfigFieldTextarea
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
        return $this;
    }


}