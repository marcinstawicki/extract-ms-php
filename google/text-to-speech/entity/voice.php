<?php

namespace MsPhp\Google\TextToSpeech\Entity;

class Voice {
    const LANGUAGE_CODE_EN_GB = 'en-GB';
    const LANGUAGE_CODE_EN_US = 'en-US';
    const LANGUAGE_CODE_DE = 'de-DE';
    const LANGUAGE_CODE_FR = 'fr-FR';
    const LANGUAGE_CODE_ES = 'es-ES';
    protected $languageCode = self::LANGUAGE_CODE_EN_GB;

    const NAME_EN_GB_WAVENET_FEMALE = 'en-GB-Wavenet-A';
    const NAME_EN_GB_WAVENET_MALE = 'en-GB-Wavenet-B';
    const NAME_EN_US_WAVENET_FEMALE = 'en-US-Wavenet-A';
    const NAME_EN_US_WAVENET_MALE = 'en-US-Wavenet-B';
    const NAME_DE_WAVENET_FEMALE = 'de-DE-Wavenet-C';
    const NAME_DE_WAVENET_MALE = 'de-DE-Wavenet-B';
    const NAME_FR_WAVENET_FEMALE = 'fr-FR-Wavenet-C';
    const NAME_FR_WAVENET_MALE = 'fr-FR-Wavenet-B';
    /**
     * todo: spanish is only standard female!! 20.06.2019
     */
    const NAME_ES_STANDARD_FEMALE = 'es-ES-Standard-A';
    const NAME_ES_WAVENET_MALE = 'es-ES-Wavenet-B';
    protected $name = self::NAME_EN_GB_WAVENET_FEMALE;
    protected $result;

    public function setName(string $name): Voice {
        $this->name = $name;
        return $this;
    }

    public function setResult() {
        $languageCode = substr($this->name,0,5);
        $result = [
           'languageCode' => $languageCode,
           'name' => $this->name
        ];
        $this->result = $result;
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
}
