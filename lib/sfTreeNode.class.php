<?php
class sfTreeNode
{
    protected $nodes = array(),$attributes = array();
    protected $name, $parent = null;

    function isRoot(){
        return ($this->getParent() == null);
    }

    function getName(){
        return $this->name;
    }
    function setName($name){
        $this->name = $name;
    }
    static function loadYAML($input){
        $array = sfYaml::load($input);
        return sfTreeNode::loadArray($array);
    }

    static function loadArray($array){
        $root = new sfTreeNode;
        $root->build($array);
        return $root;
    }

    function build($array){
        foreach($array as $name => $value){
            if($name == "_attribute" || $name == "_attributes"){
                $this->setAttributes($value);
            }else{
                $node = new sfTreeNode;
                $node->setName($name);
                $node->build($value);
                $this->addChildNode($node);
            }
        }
    }

    function find($name){
        if($this->name == $name){
            return $this;
        }
        foreach($this->getChildren() as $node){
            if($r = $node->find($name)){
                return $r;
            }
        }
        return null;
    }

    function getChildren(){
        return $this->nodes;
    }

    function getParent(){
        return $this->parent;
    }
    function setParent($parent){
        $this->parent  = $parent;
    }

    function addChildNode(sfTreeNode &$node){
        $node->setParent($this);
        $this->nodes[$node->getName()] = $node;
    }
    function addLeaf(sfTreeLeaf $leaf){

    }

    function setAttributes($attr){
        $this->attributes = $attr;
    }
    function setAttribute($key,$attr){
        $this->attributes[$key] = $attr;
    }
    function getAttributes(){
        return $this->attributes;
    }
    function getAttribute($name,$default=null){
        return array_key_exists($name,$this->attributes)
            ?$this->attributes[$name]:$default;
    }
}
