<?php
/**
 * Created by PhpStorm.
 * User: regagim
 * Date: 18.12.18
 * Time: 16:03
 */

namespace App\types;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Yaml\Yaml;

class FormType extends AbstractType
{
    public function parseFile(){
        $yamlFile = "/home/regagim/sites/project/src/resources/form.yaml";
        $yaml = Yaml::parseFile($yamlFile);
        $fields = $yaml['fields'];
        return $fields;
    }
    public function buildForm(FormBuilderInterface $builder,  array $options)
    {
        $fields = $this->parseFile();

        foreach ($fields as $key => $field){
            $name = $field['name'];
            $currentType = $field['type'];
            $className = 'Symfony\Component\Form\Extension\Core\Type'.$currentType.'Type';
            $options_ = $field['options'];
            $builder
                ->add($name, $className, $options_);
        }
    }

}