<?php

namespace MsPhp\Form\Ver01\Entity;

use MsPhp\App\Entity\Env;
use MsPhp\Conversion\Entity\ConversionEncrypt;
use MsPhp\Conversion\Entity\ConversionSqlProperty;
use MsPhp\Entity\Attribute\Attribute;
use MsPhp\Entity\Attribute\AttributeBooleanType;
use MsPhp\Entity\Attribute\AttributeCharacterType;
use MsPhp\Entity\Attribute\AttributeDatetimeType;
use MsPhp\Entity\Attribute\AttributeNumericType;
use MsPhp\Entity\Attribute\Prototype\Person\Password;
use MsPhp\Entity\Entity;
use MsPhp\Entity\Attribute\ForeignKey;
use MsPhp\Entity\Attribute\Prototype\File\Filename;
use MsPhp\Html\Entity\HtmlAttribute;
use MsPhp\Html\Entity\HtmlInputHiddenElement;
use MsPhp\Html\Entity\HtmlDivElement;
use MsPhp\Html\Entity\TextNode;
use MsPhp\Quality\Entity\QualityMaxLength;
use MsPhp\Quality\Entity\QualityMaxQuantity;

class HtmlViewWorkspaceEntity extends HtmlDivElement {
    protected $entity;
    protected $viewType;
    public function __construct() {
        $this->addClass('en');
    }
    public function setEntity(Entity $instance) {
        $this->entity = $instance;
        return $this;
    }
    public function setResult(){
        $type = Entity::$viewType;
        $db = Env::clientSQL();
        $elementButton = new HtmlAttributeUnitWorkspaceEditionCollectionElementMenu();
        $attributes = $this->entity->getAttributes();
        $namePrefix = $this->entity->getName();
        $input = (new HtmlInputHiddenElement())
            ->setName($namePrefix.'[id]')
            ->setValue($this->entity->getId());
        $this->addChild($input);
        foreach ($attributes as $attribute) {
            $className = get_class($attribute);
            $parts = explode('\\', $className);
            $lastIndex = count($parts) - 1;
            $conversion = (new ConversionSqlProperty())
                ->setValue($parts[$lastIndex - 1])
                ->setResult();
            $entityName = $conversion->getResult();
            $attributeName = $attribute->getName();
            $requirements = $attribute->getQualities();
            $values = $attribute->getValues();
            $unit = (new HtmlAttributeUnit());
            $info = (new HtmlAttributeUnitInfo());
            $sLabel = Env::translation($attributeName);
            $label = (new HtmlAttributeUnitInfoLabel())
                ->addChild(new TextNode($sLabel));
            $info->addChild($label);
            $maxLength = 60;
            $maxQuantity = 1;
            foreach($requirements AS $key => $requirement){
                $rClassName = get_class($requirement);
                if(strpos($rClassName,QualityMaxLength::class) !== false){
                    $maxLength = $requirement->getShallValue();
                }
                if(strpos($rClassName,QualityMaxQuantity::class) !== false){
                    $maxQuantity = $requirement->getShallValue();
                }
                $conversion = (new ConversionEncrypt())
                    ->setValue($rClassName)
                    ->setSalt('Jd89QW!')
                    ->setResult();
                $nRequirement = (new HtmlAttributeUnitInfoRequirement());
                $nRequirement->addClass('q_'.$conversion->getResult());
                $labels = implode(', ',$requirement->getLabels());
                $nRequirement->addChild(new TextNode($labels));
                $info->addChild($nRequirement);
            }
            $unit->addChild($info);
            $workspace = (new HtmlAttributeUnitWorkspace());
            $trigger = (new HtmlAttributeUnitWorkspaceTrigger());
            $edition = (new HtmlAttributeUnitWorkspaceEdition());
            $att = (new HtmlAttribute())
                ->setName('m')
                ->setValue($maxQuantity);
            $collection = (new HtmlAttributeUnitWorkspaceEditionCollection())
                ->addAttribute($att);
            switch(true){
                case $attribute instanceof AttributeNumericType:
                    $foreignKey = $attribute->getForeignKey();
                    if ($foreignKey instanceof ForeignKey) {
                        $children = $attribute->getChildren();
                        if(empty($children)){
                            $trigger->setIconType(HtmlAttributeUnitWorkspaceTrigger::ICON_TYPE_SELECT);
                            $workspace->addChild($trigger);
                            $nAttribute = $foreignKey->getReference();
                            $rows = [];
                            if($nAttribute instanceof Attribute){
                                $nValues = $nAttribute->getValues();
                                if(empty($nValues)){
                                    $nClassName = get_class($nAttribute);
                                    $nParts = explode('\\', $nClassName);
                                    $nLastIndex = count($nParts) - 1;
                                    $conversion = (new ConversionSqlProperty())
                                        ->setValue($nParts[$nLastIndex - 1])
                                        ->setResult();
                                    $nEntityName = $conversion->getResult();
                                    $nAttributeName = $nAttribute->getName();
                                    $sql = "SELECT id, $nAttributeName FROM $nEntityName.$nAttributeName ORDER BY id ASC";
                                    $db->setQuery($sql)->setResult();
                                    $rows = $db->getResult();
                                    if(count($rows) > 20){
                                        $search = (new HtmlAttributeUnitWorkspaceEditionSearch());
                                        $edition->addChild($search);
                                    }
                                    array_unshift($rows,['id' => '', $nAttributeName => '&nbsp;']);
                                } else {
                                    $rows = $nValues;
                                    $nAttributeName = 'name';
                                }
                            }
                            foreach($rows as $valueKey => $row){
                                $element = (new HtmlAttributeUnitWorkspaceEditionCollectionElement());
                                $name = (new AttributeFullName())
                                    ->setPrefix($namePrefix)
                                    ->setAttributeName($attributeName)
                                    ->setValueKey($valueKey)
                                    ->setResult();
                                $inputName = $name->getResult();
                                $input = (new HtmlInputHidden())
                                    ->setName($inputName)
                                    ->setValue($row['id']);
                                $fake = (new HtmlDivElement())
                                    ->addClass('option-text')
                                    ->addChild(new TextNode($row[$nAttributeName]));
                                if($valueKey === 0 && empty($values)){
                                    $element->addClass('a1');
                                        $fake->addClass('s1');
                                } else if(in_array($row['id'],$values) === true){
                                    $element->addClass('a1');
                                        $fake->addClass('s1');
                                } else {
                                    $element->addClass('a0');
                                        $fake->addClass('s0');
                                    $input->setIsDisabled(true);
                                }
                                $element->addChild($elementButton)
                                    ->addChild($fake)
                                    ->addChild($input);
                                $collection->addChild($element);
                            }
                            $edition->addChild($collection);
                            $workspace->addChild($edition);
                            $unit->addChild($workspace);
                            $this->addChild($unit);
                        } else {
                            if($maxQuantity > 1){
                                $unitMenu = new HtmlAttributeUnitMenu();
                                $add = (new HtmlAttributeUnitMenuTrigger())->setIconType(HtmlAttributeUnitMenuTrigger::ICON_TYPE_ADD_ONE);
                                $remove = (new HtmlAttributeUnitMenuTrigger())->setIconType(HtmlAttributeUnitMenuTrigger::ICON_TYPE_REMOVE_ALL);
                                $unitMenu->addChild($add)->addChild($remove);
                                $unit->addChild($unitMenu);
                            }
                            foreach($children as $valueKey => $child){
                                if($maxQuantity > 1){
                                    $entityMenu = new HtmlAttributeUnitEntityMenu();
                                    $remove = (new HtmlAttributeUnitEntityMenuTrigger())->setIconType(HtmlAttributeUnitEntityMenuTrigger::ICON_TYPE_REMOVE);
                                    $entityMenu->addChild($remove);
                                    $unit->addChild($entityMenu);
                                }
                                $name = (new AttributeFullName())
                                    ->setPrefix($namePrefix)
                                    ->setAttributeName($attributeName)
                                    ->setValueKey($valueKey)
                                    ->setResult();
                                $prefix = $name->getResult();
                                $child->setName($prefix);
                                $viewWorkspaceEntity = (new HtmlViewWorkspaceEntity())
                                    ->setEntity($child);
                                $unit->addChild($viewWorkspaceEntity);
                            }
                            $this->addChild($unit);
                        }
                    }
                    break;
                case $attribute instanceof Filename:
                    $element = (new HtmlAttributeUnitWorkspaceEditionCollectionElement())
                        ->addClass('a1');
                    if(!empty($values)){
                        $fake = (new HtmlDivElement())
                            ->addClass('file-text')
                            ->addClass('a1')
                            ->addChild(new TextNode($values[0]));
                        $element->addChild($elementButton)
                            ->addChild($fake);
                    }
                    $name = (new AttributeFullName())
                        ->setPrefix($namePrefix)
                        ->setAttributeName($attributeName)
                        ->setValueKey(0)
                        ->setResult();
                    $inputName = $name->getResult();
                    $input = (new HtmlInputFileHidden())
                        ->setName($inputName);
                    $element->addChild($input);
                    $collection->addChild($element);
                    $edition->addChild($collection);
                    $workspace->addChild($edition);
                    $unit->addChild($workspace);
                    $this->addChild($unit);
                    break;
                case $attribute instanceof AttributeDatetimeType:
                case $attribute instanceof AttributeCharacterType:
                    $value = empty($values) ? null : $values[0];
                    if($attribute instanceof AttributeDatetimeType) {
                        $valueType = $attribute->getValueType();
                        switch($valueType){
                            case AttributeDatetimeType::VALUE_TYPE_DATE:
                                $trigger->setIconType(HtmlAttributeUnitWorkspaceTrigger::ICON_TYPE_DATE);
                                break;
                            case AttributeDatetimeType::VALUE_TYPE_TIME:
                                $trigger->setIconType(HtmlAttributeUnitWorkspaceTrigger::ICON_TYPE_TIME);
                                break;
                            case AttributeDatetimeType::VALUE_TYPE_TIMESTAMP:
                                $trigger->setIconType(HtmlAttributeUnitWorkspaceTrigger::ICON_TYPE_TIMESTAMP);
                                break;
                        }
                    } else {
                        if($attribute instanceof Password){
                            $trigger->setIconType(HtmlAttributeUnitWorkspaceTrigger::ICON_TYPE_PASSWORD);
                        } else {
                            $trigger->setIconType(HtmlAttributeUnitWorkspaceTrigger::ICON_TYPE_TEXT);
                        }
                    }
                    $workspace->addChild($trigger);
                    $element = (new HtmlAttributeUnitWorkspaceEditionCollectionElement())
                        ->addClass('a1');
                    if($maxLength <= 60){
                        $input = (new HtmlInputText())
                            ->setValue($value);
                    } else {
                        $input = (new HtmlInputTextArea())
                            ->addChild($value);
                    }
                    $input->setMaxLength($maxLength);
                    $name = (new AttributeFullName())
                        ->setPrefix($namePrefix)
                        ->setAttributeName($attributeName)
                        ->setValueKey(0)
                        ->setResult();
                    $inputName = $name->getResult();
                    $input->setName($inputName);
                    $element->addChild($elementButton)
                        ->addChild($input);
                    $collection->addChild($element);
                    $edition->addChild($collection);
                    $workspace->addChild($edition);
                    $unit->addChild($workspace);
                    $this->addChild($unit);
                    break;
                case $attribute instanceof AttributeBooleanType:
                    $trigger->setIconType(HtmlAttributeUnitWorkspaceTrigger::ICON_TYPE_SELECT);
                    $workspace->addChild($trigger);
                    foreach($attribute->getOptions() as $key => $option){
                        $element = (new HtmlAttributeUnitWorkspaceEditionCollectionElement());
                        $name = (new AttributeFullName())
                            ->setPrefix($namePrefix)
                            ->setAttributeName($attributeName)
                            ->setValueKey(0)
                            ->setResult();
                        $inputName = $name->getResult();
                        $input = (new HtmlInputHidden())
                            ->setValue($key)
                            ->setName($inputName);
                        $fake = (new HtmlDivElement())
                            ->addClass('option-text')
                            ->addChild(new TextNode($option));
                        if(in_array($option,$values) === true){
                            $element->addClass('a1')
                                ->addClass('s1');
                        } else {
                            $element->addClass('a0')
                                ->addClass('s0');
                            $input->setIsDisabled(true);
                        }
                        $element->addChild($elementButton)
                            ->addChild($fake)
                            ->addChild($input);
                        $collection->addChild($element);
                    }
                    $edition->addChild($collection);
                    $workspace->addChild($edition);
                    $unit->addChild($workspace);
                    $this->addChild($unit);
                    break;
            }
        }
        return parent::setResult();
    }
}
