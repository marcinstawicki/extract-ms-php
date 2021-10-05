<?php

namespace MsPhp\Entity;

use MsPhp\App\Entity\Env;
use MsPhp\Conversion\Entity\Conversion;
use MsPhp\Conversion\Entity\ConversionSqlProperty;
use MsPhp\Entity\Attribute\Attribute;
use MsPhp\Form\Ver01\Entity\HtmlFormAutocompleteApply;
use MsPhp\Form\Ver01\Entity\HtmlFormAutocompleteForget;
use MsPhp\Form\Ver01\Entity\HtmlFormAutocompleteRemember;
use MsPhp\Form\Ver01\Entity\HtmlFormReset;
use MsPhp\Form\Ver01\Entity\HtmlFormSubmitStore;
use MsPhp\Form\Ver01\Entity\HtmlView;
use MsPhp\Form\Ver01\Entity\HtmlViewInfo;
use MsPhp\Form\Ver01\Entity\HtmlViewWorkspace;
use MsPhp\Form\Ver01\Entity\HtmlViewWorkspaceEntity;
use MsPhp\Value\Entity\Value;

class Entity {
    protected $id;
    protected $parentId;
    protected $name = '';
    protected $attributes = [];
    protected $descriptions =  [];
    protected $values = true;
    protected $archive;
    const VIEW_TYPE_FORM_STAND_ALONE = 'form-stand-alone';
    const VIEW_TYPE_FORM_PORTABLE = 'form-portable';
    const VIEW_TYPE_PROFILE = 'profile';
    public static $viewType = self::VIEW_TYPE_FORM_STAND_ALONE;
    protected $view;

    public function setId($id) {
        $this->id = (int) $id;
        return $this;
    }
    public function setParentId($parentId) {
        $this->parentId = $parentId;
        return $this;
    }
    public function setName(string $name) {
        $this->name = $name;
        return $this;
    }
    public function addDescription($description) {
        $this->descriptions[] = $description;
        return $this;
    }
    public function setAttributes(array $attributes) {
        $this->attributes = $attributes;
        return $this;
    }
    public function addAttribute(Attribute $instance) {
        $this->attributes[] = $instance;
        return $this;
    }
    public function setValues($areValues = [],$level = 0) {
        /**
         * todo: add ids to children if exist
         * <input type="hidden" name="person[0][id]" value="1">
         * <input type="text" name="person[0][att][address_id][0][att][street][0]" value="">
         * <input type="text" name="person[0][att][address_id][0][att][street][1]" value="">
         */
        $values = [
            'person' => [
                [
                    'id' => '',
                    'att' => [
                        'gender_id' => [1],
                        'forename' => ['Thomas'],
                        'surname' => ['Klawecki'],
                        'address_id' => [
                            [
                                'id' => '',
                                'att' => [
                                    'country_id' => [2],
                                    'city' => ['Piotrkow Trybunalski'],
                                    'postal_code' => ['97300'],
                                    'street' => ['Slowackiego 154']
                                ]
                            ],
                            [
                                'id' => '',
                                'att' => [
                                    'country_id' => [1,2,3],
                                    'city' => ['Bad Homburg'],
                                    'postal_code' => ['61352'],
                                    'street' => ['In den Brühlwiesen 29']
                                ]
                            ],
                            [
                                'id' => '',
                                'att' => [
                                    'country_id' => [1,5],
                                    'city' => ['Maslowice'],
                                    'postal_code' => ['97515'],
                                    'street' => ['Przerab']
                                ]
                            ]
                        ],
                    ]
                ]
            ]
        ];
        $values = true;
        try {
            if (empty($areValues) && !empty($this->id)) {
                $db = Env::clientSQL();
                $select = [];
                $from = [];
                $count = count($this->attributes);
                $keys = range(1, $count);
                foreach ($this->attributes as $attribute) {
                    $className = get_class($attribute);
                    $parts = explode('\\', $className);
                    $lastIndex = count($parts) - 1;
                    $conversion = (new ConversionSqlProperty())
                        ->setValue($parts[$lastIndex - 1])
                        ->setResult();
                    $entityName = $conversion->getResult();
                    $attributeName = $attribute->getName();
                    $idValueType = $attribute->getIdValueType();
                    if ($attribute instanceof AttributeNumericType) {
                        if (strpos($idValueType, 'serial') !== false) {
                            $select[0] = "SELECT DISTINCT ON(t0.id) t0.id, t0.$attributeName";
                            $from[0] = "FROM $entityName.$attributeName AS t0";
                        } else {
                            $key = array_shift($keys);
                            $foreignKey = $attribute->getForeignKey();
                            if ($foreignKey instanceof ForeignKey) {
                                $select[$key] = "array_to_json(ARRAY(SELECT $attributeName FROM $entityName.$attributeName WHERE id=t0.id)) AS $attributeName";
                                $from[$key] = "";
                            } else {
                                $select[$key] = "t$key.$attributeName";
                                $from[$key] = "LEFT JOIN $entityName.$attributeName AS t$key USING(id)";
                            }
                        }
                    } else {
                        if (strpos($idValueType, 'serial') !== false) {
                            $select[0] = "SELECT DISTINCT ON(t0.id) t0.id, t0.$attributeName";
                            $from[0] = "FROM $entityName.$attributeName AS t0";
                        } else {
                            $key = array_shift($keys);
                            $select[$key] = "t$key.$attributeName";
                            $from[$key] = "LEFT JOIN $entityName.$attributeName AS t$key USING(id)";
                        }
                    }
                }
                ksort($select);
                ksort($from);
                $sql = implode(', ', $select).' ';
                $sql .= implode(' ', $from).' ';
                $sql .= 'WHERE t0.id=' . $this->id;
                $db->setQuery($sql)->setResult();
                $row = $db->getResult(0);
                foreach ($this->attributes as $attribute) {
                    $attributeName = $attribute->getName();
                    $value = $row[$attributeName];
                    if ($attribute instanceof AttributeNumericType) {
                        $foreignKey = $attribute->getForeignKey();
                        if ($foreignKey instanceof ForeignKey) {
                            if(substr($value,0,1) === '['){
                                $values = json_decode($value);
                            } else {
                                $values = [$value];
                            }
                            $children = $attribute->getChildren();
                            if (empty($children)) {
                                $attribute->setValues($values)
                                    ->setResult();
                            } else {
                                $emptyChild = $children[0];
                                foreach ($values as $key => $childId) {
                                    if($key === 0){
                                        $attribute->unsetChildren();
                                    }
                                    $nEntity = clone $emptyChild;
                                    $nEntity->setId($childId)
                                        ->setValues();
                                    $attribute->addChild($nEntity);
                                }
                            }
                        } else {
                            $conversion = $attribute->getConversionFromSql();
                            if ($conversion instanceof Conversion) {
                                $conversion->setValue($value)
                                    ->setResult();
                                $value = $conversion->getResult();
                            }
                            $attribute->addValue($value)
                                ->setResult();
                        }
                    } else {
                        $conversion = $attribute->getConversionFromSql();
                        if ($conversion instanceof Conversion) {
                            $conversion->setValue($value)
                                ->setResult();
                            $value = $conversion->getResult();
                        }
                        $attribute->addValue($value)
                            ->setResult();
                    }
                }
            } else {
                if($level === 0){
                    $areValues = $areValues[$this->name][0]['att'];
                }
                foreach ($this->attributes as $attribute) {
                    $attributeName = $attribute->getName();
                    if ($attribute instanceof AttributeNumericType) {
                        $foreignKey = $attribute->getForeignKey();
                        if ($foreignKey instanceof ForeignKey) {
                            $children = $attribute->getChildren();
                            if (empty($children)) {
                                $subValues = $areValues[$attributeName];
                                $attribute->setValues($subValues)
                                    ->setResult();
                            } else {
                                $count = isset($areValues[$attributeName]) ? count($areValues[$attributeName])-1 : 0;
                                $emptyChild = clone $children[0];
                                $range = range(0, $count);
                                foreach ($range as $key) {
                                    if($key === 0){
                                        $attribute->unsetChildren();
                                    }
                                    $nEntity = clone $emptyChild;
                                    $subId = $areValues[$attributeName][$key]['id'];
                                    $subValues = $areValues[$attributeName][$key]['att'];
                                    $nEntity->setId($subId)
                                        ->setValues($subValues,++$level);
                                    $attribute->addChild($nEntity);
                                }
                            }
                        } else {
                            $attribute->setValues($areValues[$attributeName])
                                ->setResult();
                        }
                    } else {
                        $subValues = $areValues[$attributeName];
                        $attribute->setValues($subValues)
                            ->setResult();
                    }
                }
            }
        } catch (\Exception $e) {
            $values = false;
        }
        $this->values = $values;
        return $this;
    }
    public function setArchive() {
        /**
         * first go through serial and all with one value or common
         */
        $db = Env::clientSQL();
        $insert = [];
        $count = count($this->attributes)-1;
        $keys = range(1, $count);
        //$this->id = null;
        foreach ($this->attributes as $attribute) {
            $className = get_class($attribute);
            $parts = explode('\\', $className);
            $lastIndex = count($parts) - 1;
            $conversion = (new ConversionSqlProperty())
                ->setValue($parts[$lastIndex - 1])
                ->setResult();
            $entityName = $conversion->getResult();
            $attributeName = $attribute->getName();
            $valueType = $attribute->getValueType();
            $idValueType = $attribute->getIdValueType();
            $values = $attribute->getValues();
            $constraint = $attributeName.'_pkey';
            if ($attribute instanceof AttributeNumericType) {
                $commonIds = [[]];
                foreach ($values as $subKey => $value) {
                    $conversion = $attribute->getConversionToSql();
                    if ($conversion instanceof Conversion) {
                        $conversion->setValue($value)
                            ->setResult();
                        $value = $conversion->getResult();
                    }
                    switch($valueType){
                        case Value::TYPE_BIGINT:
                        case Value::TYPE_INT:
                        case Value::TYPE_SMALLINT:
                            $value = (int) $value;
                            break;
                        default:
                            $value = "'".trim($value,"'")."'";
                            break;
                    }
                    if (strpos($idValueType, 'serial') !== false) {
                        if (empty($this->id)) {
                            $insert[0] = "WITH t00 AS (INSERT INTO $entityName.$attributeName ($attributeName) VALUES ($value) RETURNING id)";
                        } else {
                            $insert[0] = "WITH t00 AS (INSERT INTO $entityName.$attributeName (id,$attributeName) VALUES ({$this->id},$value) ON CONFLICT ON CONSTRAINT $constraint DO UPDATE SET $attributeName=$value)";
                        }
                    } else {
                        $foreignKey = $attribute->getForeignKey();
                        if ($foreignKey instanceof ForeignKey) {
                            $children = $attribute->getChildren();
                            if (empty($children)) {
                                $commonIds[$entityName.'__'.$attributeName][] = $value;
                                $key = array_shift($keys);
                                $insert += $this->getInsert($value, $attribute, $key, $entityName, $attributeName);
                            }
                        } else {
                            $key = array_shift($keys);
                            $insert += $this->getInsert($value, $attribute, $key, $entityName, $attributeName);
                        }
                    }
                }
            } else {
                $value = $values[0];
                if (strpos($idValueType, 'serial') !== false) {
                    $conversion = $attribute->getConversionToSql();
                    if ($conversion instanceof Conversion) {
                        $conversion->setValue($value)
                            ->setResult();
                        $value = $conversion->getResult();
                    }
                    switch($valueType){
                        case Value::TYPE_BIGINT:
                        case Value::TYPE_INT:
                        case Value::TYPE_SMALLINT:
                            $value = (int) $value;
                            break;
                        default:
                            $value = "'".trim($value,"'")."'";
                            break;
                    }
                    if (empty($this->id)) {
                        $insert[0] = "WITH t00 AS (INSERT INTO $entityName.$attributeName ($attributeName) VALUES ($value) RETURNING id)";
                    } else {
                        //todo: ON CONFLICT (primaryKey) -> address_id_pk or address_id_pkey (different names!!!! check and change)
                        $insert[0] = "WITH t00 AS (INSERT INTO $entityName.$attributeName (id,$attributeName) VALUES ({$this->id},$value) ON CONFLICT ON CONSTRAINT $constraint DO UPDATE SET $attributeName=$value)";
                    }
                } else {
                    $key = array_shift($keys);
                    $insert += $this->getInsert($value, $attribute, $key, $entityName, $attributeName);
                }
            }
        }
        ksort($insert);
        $last = end($insert);
        $nLast = rtrim(substr($last,8),')');
        $sql = implode(', ', $insert);
        $sql = str_replace(', '.$last, ' '.$nLast,$sql);
        $db->setQuery($sql)->setResult();
        $row = $db->getResult(0);
        $this->id = (int) $row['id'];
        /**
         * go through all attributes which have children
         */
        $insert = ['BEGIN;'];
        foreach ($this->attributes as $attribute) {
            if ($attribute instanceof AttributeNumericType) {
                $className = get_class($attribute);
                $parts = explode('\\', $className);
                $lastIndex = count($parts) - 1;
                $conversion = (new ConversionSqlProperty())
                    ->setValue($parts[$lastIndex - 1])
                    ->setResult();
                $entityName = $conversion->getResult();
                $attributeName = $attribute->getName();
                $foreignKey = $attribute->getForeignKey();
                $constraint = $attributeName.'_pkey';
                if ($foreignKey instanceof ForeignKey) {
                    $nAttribute = $foreignKey->getReference();
                    $nClassName = get_class($nAttribute);
                    $nParts = explode('\\', $nClassName);
                    $nLastIndex = count($nParts) - 1;
                    $conversion = (new ConversionSqlProperty())
                        ->setValue($nParts[$nLastIndex - 1])
                        ->setResult();
                    $nEntityName = $conversion->getResult();
                    $nAttributeName = $nAttribute->getName();
                    $children = $attribute->getChildren();
                    if(!empty($children)){
                        $childrenIds = [[]];
                        $childrenIds[$entityName.'__'.$attributeName][$nEntityName.'__'.$nAttributeName] = [];
                        foreach ($children as $key => $child) {
                            $child->setArchive();
                            $childId = $child->getId();
                            $childrenIds[$entityName.'__'.$attributeName][$nEntityName.'__'.$nAttributeName][] = $childId;
                            $insert[] = "INSERT INTO $entityName.$attributeName (id,$attributeName) VALUES ({$this->id},$childId) ON CONFLICT ON CONSTRAINT $constraint DO UPDATE SET $attributeName=$childId;";
                        }
                    }
                }
            }
        }
        $insert[] = 'COMMIT;';
        if(count($insert) > 2){
            ksort($insert);
            $sql = implode('', $insert);
            $db->setQuery($sql)->setResult();
        }

        /**
         * delete all previous values which has been removed by the user on editing
         */
        $delete = ['BEGIN;'];
        foreach ($this->attributes as $attribute) {
            if ($attribute instanceof AttributeNumericType) {
                $className = get_class($attribute);
                $parts = explode('\\', $className);
                $lastIndex = count($parts) - 1;
                $conversion = (new ConversionSqlProperty())
                    ->setValue($parts[$lastIndex - 1])
                    ->setResult();
                $entityName = $conversion->getResult();
                $attributeName = $attribute->getName();
                $foreignKey = $attribute->getForeignKey();
                if ($foreignKey instanceof ForeignKey) {
                    $nAttribute = $foreignKey->getReference();
                    $nClassName = get_class($nAttribute);
                    $nParts = explode('\\', $nClassName);
                    $nLastIndex = count($nParts) - 1;
                    $conversion = (new ConversionSqlProperty())
                        ->setValue($nParts[$nLastIndex - 1])
                        ->setResult();
                    $nEntityName = $conversion->getResult();
                    $nAttributeName = $nAttribute->getName();
                    $children = $attribute->getChildren();
                    if(empty($children)){
                        if(isset($commonIds) && isset($commonIds[$entityName.'__'.$attributeName])) {
                            $sIds = implode(', ',$commonIds[$entityName.'__'.$attributeName]);
                            $delete[] = "DELETE FROM $entityName.$attributeName WHERE id={$this->id} AND $attributeName NOT IN($sIds);";
                        }
                    } else {
                        if(isset($childrenIds) && isset($childrenIds[$entityName.'__'.$attributeName]) && isset($childrenIds[$entityName.'__'.$attributeName][$nEntityName.'__'.$nAttributeName])) {
                            $sIds = implode(', ',$childrenIds[$entityName.'__'.$attributeName][$nEntityName.'__'.$nAttributeName]);
                            $delete[] = "DELETE FROM $nEntityName.$nAttributeName WHERE id IN(SELECT $attributeName FROM $entityName.$attributeName WHERE id={$this->id} AND $attributeName NOT IN($sIds));";
                        }
                    }
                }
            }
        }
        $delete[] = 'COMMIT;';
        if(count($delete) > 2){
            ksort($delete);
            $sql = implode('', $delete);
            $db->setQuery($sql)->setResult();
        }
        $this->archive = true;
        return $this;
    }
    public function setView($viewType,array $buttonClasses = [HtmlFormSubmitStore::class,HtmlFormReset::class,HtmlFormAutocompleteRemember::class, HtmlFormAutocompleteApply::class,HtmlFormAutocompleteForget::class]) {
        self::$viewType = $viewType;
        $viewInfo = new HtmlViewInfo();
        $active = count($this->descriptions) > 0 ? 1 : 0;
        $viewInfo->addClass('a'.$active);
        foreach($this->descriptions as $description){
            $viewInfo->addChild($description);
        }
        $viewWorkspace = new HtmlViewWorkspace();
        $this->name.= '[0]';
        $viewWorkspaceEntity = (new HtmlViewWorkspaceEntity())
            ->setEntity($this);
        $viewWorkspace->addChild($viewWorkspaceEntity);
        foreach($buttonClasses as $buttonClass){
            $viewWorkspace->addChild(new $buttonClass());
        }
        $view = (new HtmlView())
            ->addChild($viewInfo)
            ->addChild($viewWorkspace);
        switch($viewType){
            case self::VIEW_TYPE_FORM_STAND_ALONE:
            case self::VIEW_TYPE_PROFILE:
                $view->addClass('s1');
                break;
            case self::VIEW_TYPE_FORM_PORTABLE:
                $view->addClass('s0');
                break;
        }
        $this->view = $view;
        return $this;
    }
    public function getView() {
        return $this->view;
    }
    public function getAreValues() : bool {
        return $this->values;
    }

    public function getId() {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
    public function getAttributes(): array {
        return $this->attributes;
    }
    public function getDescriptions() : array {
        return $this->descriptions;
    }
    private function getInsert($value, $attribute, $key, $entityName, $attributeName) {
        $constraint = $attributeName.'_pkey';
        $conversion = $attribute->getConversionToSql();
        if ($conversion instanceof Conversion) {
            $conversion->setValue($value)
                ->setResult();
            $value = $conversion->getResult();
        }
        $valueType = $attribute->getValueType();
        switch($valueType){
            case Value::TYPE_BIGINT:
            case Value::TYPE_INT:
            case Value::TYPE_SMALLINT:
                $value = (int) $value;
                break;
            default:
                $value = "'".trim($value,"'")."'";
                break;
        }
        $tPevKey = 't'.str_pad($key-1, 2, '0', STR_PAD_LEFT);
        $tKey = 't'.str_pad($key, 2, '0', STR_PAD_LEFT);
        if (empty($this->id)) {
            $insert[$key] = "$tKey AS (INSERT INTO $entityName.$attributeName (id,$attributeName) SELECT id,$value FROM $tPevKey RETURNING id)";
        } else {
            $insert[$key] = "$tKey AS (INSERT INTO $entityName.$attributeName (id,$attributeName) VALUES ({$this->id},$value) ON CONFLICT ON CONSTRAINT $constraint DO UPDATE SET $attributeName=$value RETURNING id)";
        }
        return $insert;
    }
    /**
     * @important: the standard method "clone" does not do its job!
     */
    public function __clone() {
        $vars = get_object_vars($this);
        foreach ($vars as $name => $value) {
            if (is_object($this->$name)) {
                $this->$name = clone $this->$name;
            } else if (is_array($this->$name)) {
                foreach ($this->$name as &$arrayValue) {
                    if (is_object($arrayValue)) {
                        $arrayValue = clone $arrayValue;
                    }
                    unset($arrayValue);
                }
            }
        }
    }
}
