<?php
namespace MsPhp\App\Entity;

use MsPhp\Conversion\Entity\ConversionDecrypt;
use MsPhp\Conversion\Entity\ConversionEncrypt;
use MsPhp\Entity\Attribute\Prototype\Person;
use MsPhp\Security\Process\Security;

class UriAdvanced extends UriAbstract {

    protected ?Person $user = null;
    protected array $checkpoints = [];
    protected string $checkpoint = '';
    protected string $environment = '';

    public function __construct() {
        parent::__construct();
    }
    public function setCheckpoint($pathname): self {
        $this->checkpoint = $pathname;
        return $this;
    }
    public function setCheckpoints($checkpoints): self {
        $this->checkpoints = $checkpoints;
        return $this;
    }
    public function setUser(Person $user): self
    {
        $this->user = $user;
        return $this;
    }
    public function setEnvironment(string $environment): self
    {
        $this->environment = $environment;
        return $this;
    }
    protected function setRelativeResult(): self {
        $result = '';
        if($this->user instanceof Person){
            if(!empty($this->checkpoint) && !empty($this->checkpoints)){
                if($this->environment === Configuration::ENVIRONMENT_DEV){
                    $path = '/'.str_replace('.','/',$this->checkpoint);
                } else {
                    $checkpointID = isset($this->checkpoints[$this->checkpoint]) ? (int) $this->checkpoints[$this->checkpoint]['id'] : 0;
                    $path = '/'.$checkpointID;
                }
                $result .= $path;
                $forHash = [
                    'path' => $result
                ];
                $vector = $this->user->getVector();
                $salt = Security::getSalt($vector);
                if (!empty($this->query)) {
                    if($this->environment === Configuration::ENVIRONMENT_PRO){
                        if(array_key_exists('_s',$this->query)){
                            $result = $this->query['_s'];
                            $conversion = (new ConversionDecrypt())
                                ->setInitializationVector($vector)
                                ->setSalt($salt)
                                ->setValue($result)
                                ->setResult();
                            $res = @json_decode($conversion->getResult(),true);
                            if($res !== false && !is_null($res)){
                                if(count($res) === 1){
                                    $this->query = [];
                                } else {
                                    unset($res['path']);
                                    $this->query = $res;
                                }
                            }
                        }
                    } else {
                        $this->query['_t'] = $this->user->getToken();
                    }
                    $forHash += $this->query;
                    $result .= '?' . http_build_query($this->query);
                }
                if (!empty($this->fragment)) {
                    $result .= '#' . $this->fragment;
                    $forHash['#'] = $this->fragment;
                }
                if($this->environment === Configuration::ENVIRONMENT_PRO){
                    $excluded = ['.js','.css','.png','.jpg','.svg'];
                    $exclude = false;
                    foreach($excluded as $extension){
                        $length = strlen($extension);
                        if(substr($path,-$length) === $extension){
                            $exclude = true;
                        }
                    }
                    if($exclude === false){
                        $forHash = json_encode($forHash);
                        $conversion = (new ConversionEncrypt())
                            ->setInitializationVector($vector)
                            ->setSalt($salt)
                            ->setValue($forHash)
                            ->setResult();
                        $result = $path.'/'.base64_encode($conversion->getResult()).$this->user->getToken();
                    } else {
                        $result = $path;
                    }
                }
            }
        }
        $this->result = $result;
        return $this;
    }
}
