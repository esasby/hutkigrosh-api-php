<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 30.09.2018
 * Time: 15:15
 */

namespace esas\hutkigrosh\view\admin;


use esas\hutkigrosh\view\admin\fields\ConfigField;
use esas\hutkigrosh\view\admin\fields\ConfigFieldCheckbox;
use esas\hutkigrosh\view\admin\fields\ConfigFieldList;
use esas\hutkigrosh\view\admin\fields\ConfigFieldPassword;
use esas\hutkigrosh\view\admin\fields\ConfigFieldTextarea;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig_TemplateWrapper;

/**
 * Class ConfigurationRender обеспечивает render (в html) полей для редактирования настроек плагина
 * В плагинах для конкретных CMS должен быть создан наследник и переопределены методы render****Field
 * (минимум должен быть переопределен renderTextField).
 * Пример использования для opencart:
 * $configFieldsRender = new ConfigurationRenderOpencart();
 * $configFieldsRender->addAll();
 * $configFieldsRender->addField(new ConfigFieldNumber <> ); // добавление какого-то особоного поля для CMS
 * $configFieldsRender->render(); // формирует html
 * @package esas\hutkigrosh\view\admin
 */
abstract class ConfigFormTwig extends ConfigFormHtml
{
    /**
     * @var FilesystemLoader
     */
    protected $loader;
    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var Twig_TemplateWrapper
     */
    protected $template;

    /**
     * ConfigFormTwig constructor.
     */
    public function __construct($templatePath, $templateName)
    {
        parent::__construct();
        $this->loader = new FilesystemLoader($templatePath);
        $this->twig = new Environment($this->loader, [
            'cache' => $templatePath . '/compilation_cache',
        ]);
        $this->template = $this->twig->load($templateName);
    }

    public function generateTextField(ConfigField $configField)
    {
        return $this->template->renderBlock('fieldText', ['configField' => $configField]);
    }

    public function generateTextAreaField(ConfigFieldTextarea $configField)
    {
        return $this->template->renderBlock('fieldTextArea', ['configField' => $configField]);
    }

    public function generatePasswordField(ConfigFieldPassword $configField)
    {
        return $this->template->renderBlock('fieldPassword', ['configField' => $configField]);
    }

    public function generateCheckboxField(ConfigFieldCheckbox $configField)
    {
        return $this->template->renderBlock('fieldCheckbox', ['configField' => $configField]);
    }

    public function generateListField(ConfigFieldList $configField)
    {
        return $this->template->renderBlock('fieldList', ['configField' => $configField]);
    }


}