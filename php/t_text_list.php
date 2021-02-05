<?php

class TTextList{
    private $id;
    private $data;
    private $link;

    private function checkPresence($titleA,$catA,$msgA){
        $sql = "select id from ";
        $sql .= DB_PREFIX;
        $sql .= "portfolio where ";
        $sql .= "title=:fn and ";
        $sql .= "category=:cat and ";
        $sql .= "description=:msg";
        $stmt = $this->link->prepare($sql);
        $stmt->bindParam(":fn",$titleA);
        $stmt->bindParam(":cat",$catA);
        $stmt->bindParam(":msg",$msgA);
        $stmt->execute();
        return is_array($stmt->fetch(PDO::FETCH_ASSOC))?true:false;
    }
    
    private function descExists($descA){
        $sql = "select id from ".DB_PREFIX."portfolio where description=:pdesc";
        $stmt = $this->link->prepare($sql);
        $stmt->bindParam(":pdesc",$descA);
        $stmt->execute();
        return is_array($stmt->fetch(PDO::FETCH_ASSOC))?true:false;
    }

    private function titleExists($nameA){
        $sql = "select id from ".DB_PREFIX."portfolio where title=:ptitle";
        $stmt = $this->link->prepare($sql);
        $stmt->bindParam(":ptitle",$nameA);
        $stmt->execute();
        return is_array($stmt->fetch(PDO::FETCH_ASSOC))?true:false;
    }

    public function delete($msgID){
        $sql = "delete from ";
        $sql .= DB_PREFIX;
        $sql .= "portfolio where id=:mid";
        $stmt = $this->link->prepare($sql);
        $stmt->bindParam(":mid",$msgID);
        return $stmt->execute();
    }

    public function getData($fieldA){
        if($fieldA=="id"){
            return $this->id;
        }
        else if(array_key_exists($fieldA,$this->data)){
            return $this->data[$fieldA];
        }
    }

    public function getList(){
        $stmt = $this->link->prepare("select * from ".DB_PREFIX."portfolio");
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res;    
    }

    public function getListLength(){
        $stmt = $this->link->prepare("select count(*) from ".DB_PREFIX."portfolio");
        $stmt->execute();
        $res = $stmt->fetchAll();
        return $res[0][0];    
    }

    public function __construct($dbLinkA=null){
        $this->id = null;
        $this->data = array(
            "title"=>"",
            "category"=>"",
            "description"=>""
        );
        $this->link = $dbLinkA;
    }

    public function getDBLink(){
        return $this->link;
    }

    public function insert($titleA,$catA,$msgA){
        if(!$this->checkPresence($titleA,$msgA)){
            $sql = "insert into ";
            $sql .= DB_PREFIX;
            $sql .= "portfolio(title,category,description) ";
            $sql .= "values(:fn,:cat,:msg)";
            $stmt = $this->link->prepare($sql);
            $stmt->bindParam(":fn",$titleA);
            $stmt->bindParam(":cat",$catA);
            $stmt->bindParam(":msg",$msgA);
            return $stmt->execute();
        }
        return false;
    }

    public function getById($msgID){
        $sql = "select * from ";
        $sql .= DB_PREFIX;
        $sql .= "portfolio where id=:msgid";
        $stmt = $this->link->prepare($sql);
        $stmt->bindParam(":msgid",$msgID);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if(isset($res["id"])) $this->setData("id",$res["id"]);
        if(isset($res["title"])) $this->setData("title",$res["title"]);
        if(isset($res["category"])) $this->setData("category",$res["category"]);
        if(isset($res["description"])) $this->setData("description",$res["description"]);
        return $res;    
    }

    public function getByTag($tagA){
        $sql = "select * from ";
        $sql .= DB_PREFIX;
        $sql .= "portfolio where ";
        $sql .= "title like \"%$tagA%\" or ";
        $sql .= "category like \"%$tagA%\" or ";
        $sql .= "description like \"%$tagA%\"";
        $stmt = $this->link->prepare($sql);
        $stmt->execute();        
        $res = $stmt->fetchAll();
        return $res;    
    }

    public function save(){
        if($this->id){
            //update existing
            $sql = "update ".DB_PREFIX."portfolio set ";
            $sql .= "title = :ptitle,";
            $sql .= "category = :pcat,";
            $sql .= "description = :pdesc ";
            $sql .= "where id=:uid";
            $stmt = $this->link->prepare($sql);
            $stmt->bindParam(":ptitle",$this->data['title']);
            $stmt->bindParam(":pcat",$this->data['category']);
            $stmt->bindParam(":pdesc",$this->data['description']);
            $stmt->bindParam(":uid",$this->id);
            return $stmt->execute();
        }
        else if(!$this->titleExists($this->data['title'])
        && !$this->descExists($this->data['description'])){
            //create new
            $sql = "insert into ".DB_PREFIX."portfolio(title,category,description)";
            $sql .= "values(:ptitle,:pcat,:pdesc)";
            $stmt = $this->link->prepare($sql);
            $stmt->bindParam(":ptitle",$this->data['title']);
            $stmt->bindParam(":pcat",$this->data['category']);
            $stmt->bindParam(":pdesc",$this->data['description']);
            return $stmt->execute();
        }
    }

    public function setData($fieldA,$valA){
        if($fieldA==="id"){
            $this->id = $valA;
        }
        if(array_key_exists($fieldA,$this->data)){
            $this->data[$fieldA] = $valA;
        }
    }

    public function setDBLink($dbLinkA=null){
        $this->link = (isset($dbLinkA))?$dbLinkA:null;        
    }
}

?>