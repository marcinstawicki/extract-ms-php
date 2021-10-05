<?php
namespace MsPhp\App\Entity;

use MsPhp\Html\Entity\HtmlElement;

class XmlHttpResponse {
    protected $result;
    protected $success;
    protected $failure;
    protected $appeal;
    protected $errors = [];
    protected $redirect;
    protected $postHash;

    public function setSuccess($success) {
        if($success instanceof HtmlElement){
            $success = $success->setResult()->getResult();
        }
        $this->success = $success;
        return $this;
    }
    public function setFailure($failure) {
        if($failure instanceof HtmlElement){
            $failure = $failure->setResult()->getResult();
        }
        $this->failure = $failure;
        return $this;
    }
    public function setAppeal($appeal) {
        if($appeal instanceof HtmlElement){
            $appeal = $appeal->setResult()->getResult();
        }
        $this->appeal = $appeal;
        return $this;
    }
    public function setErrors(array $errors) {
        $this->errors = $errors;
        return $this;
    }
    public function setRedirect(UriAdvanced $instance) {
        $this->redirect = $instance->setResult()->getResult();
        return $this;
    }
    public function setPostHash(string $postHash) {
        $this->postHash = $postHash;
        return $this;
    }
    public function setResult(){
        $result = [];
        if(!is_null($this->success)){
            $result['success'] = $this->success;
        } else if (!is_null($this->failure)){
            $result['failure'] = $this->failure;
        }
        if(!is_null($this->appeal)){
            $result['appeal'] = $this->appeal;
        }
        if(!empty($this->errors)){
            $result['errors'] = $this->errors;
        }
        if(!is_null($this->redirect)){
            $result['redirect'] = $this->redirect;
        }
        if(!empty($this->postHash)){
            $result['_p'] = $this->postHash;
        }
        $this->result = json_encode($result);
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
}
