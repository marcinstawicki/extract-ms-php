<?php

namespace MsPhp\Google\TextToSpeech\Process;

use MsPhp\App\Entity\Uri;
use MsPhp\Google\TextToSpeech\Entity\AudioConfig;
use MsPhp\Google\TextToSpeech\Entity\TextToSpeech;
use MsPhp\Google\TextToSpeech\Entity\Voice;
use MsPhp\Rest\Entity\CurlPost;

class TextToSpeechRequest {

    protected $credentials;
    protected $input = '';
    protected $voice;
    protected $audioConfig;
    protected $result;

    public function setCredentials(TextToSpeech $credentials) {
        $this->credentials = $credentials;
        return $this;
    }
    public function setInput(string $input): TextToSpeechRequest {
        $this->input = $input;
        return $this;
    }
    public function setVoice(Voice $instance) {
        $this->voice = $instance->setResult()->getResult();
        return $this;
    }
    public function setAudioConfig(AudioConfig $instance) {
        $this->audioConfig = $instance->setResult()->getResult();
        return $this;
    }
    public function setResult() {
        $request = [
            'input' => ['text' => $this->input],
            'voice' => $this->voice,
            'audioConfig' => $this->audioConfig
        ];
        $request = json_encode($request);
        $path = $this->credentials->getScheme().'://'.$this->credentials->getHost();
        $uri = (new Uri())
            ->setPath($path)
            ->setQuery([
                $this->credentials->getUserName() => $this->credentials->getPassword()
            ]);
        $post = (new CurlPost())
            ->setHeaders(['Content-Type: application/json; charset=utf-8'])
            ->setUrl($uri)
            ->setData($request)
            ->setResponseType(CurlPost::RESULT_TYPE_JSON)
            ->setResult();
        $audio = $post->getResult();
        if(isset($audio['audioContent'])){
            $this->result = $audio['audioContent'];
        }
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
}
