<?php

namespace MsPhp\Google\TextToSpeech\Entity;


class AudioConfig {
    const AUDIO_ENCODING_LINEAR16 = 'LINEAR16';
    const AUDIO_ENCODING_MP3 = 'MP3';
    const AUDIO_ENCODING_OGG_OPUS = 'OGG_OPUS';
    protected $audioEncoding = self::AUDIO_ENCODING_MP3;
    /**
     * [0.25, 4.0]
     */
    protected $speakingRate = 1;
    /**
     * [-20.0, 20.0]
     */
    protected $pitch = 0;
    /**
     * [-96.0, 16.0]
     */
    protected $volumeGainDb;
    protected $sampleRateHertz;
    protected $result;
    /**
     * @var array
     */
    const AUDIO_PROFILE_ID_WEARABLE = 'wearable-class-device';
    const AUDIO_PROFILE_ID_HANDSET = 'handset-class-device';
    const AUDIO_PROFILE_ID_HEADPHONE = 'headphone-class-device';
    const AUDIO_PROFILE_ID_SMALL_BLUETOOTH_SPEAKER = 'small-bluetooth-speaker-class-device';
    const AUDIO_PROFILE_ID_MEDIUM_BLUETOOTH_SPEAKER = 'medium-bluetooth-speaker-class-device';
    const AUDIO_PROFILE_ID_LARGE_HOME_ENTERTAINMENT = 'large-home-entertainment-class-device';
    const AUDIO_PROFILE_ID_LARGE_AUTOMOTIVE = 'large-automotive-class-device';
    const AUDIO_PROFILE_ID_TELEPHONY = 'telephony-class-application';
    protected $effectsProfileId = self::AUDIO_PROFILE_ID_HANDSET;

    public function setAudioEncoding(string $audioEncoding): AudioConfig {
        $this->audioEncoding = $audioEncoding;
        return $this;
    }
    public function setSpeakingRate($speakingRate) {
        $this->speakingRate = $speakingRate;
        return $this;
    }
    public function setPitch($pitch) {
        $this->pitch = $pitch;
        return $this;
    }
    public function setVolumeGainDb($volumeGainDb) {
        $this->volumeGainDb = $volumeGainDb;
        return $this;
    }
    public function setSampleRateHertz(int $sampleRateHertz): AudioConfig {
        $this->sampleRateHertz = $sampleRateHertz;
        return $this;
    }
    public function setEffectsProfileId($effectsProfileId): AudioConfig {
        $this->effectsProfileId = $effectsProfileId;
        return $this;
    }
    public function setResult() {
        $result = [
            'audioEncoding' => $this->audioEncoding,
            'speakingRate' => $this->speakingRate,
            'pitch' => $this->pitch,
            'effectsProfileId' => [$this->effectsProfileId]
        ];
        if(!is_null($this->volumeGainDb)){
            $result['volumeGainDb'] = $this->volumeGainDb;
        }
        if(!is_null($this->sampleRateHertz)){
            $result['sampleRateHertz'] = $this->sampleRateHertz;
        }
        $this->result = $result;
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
}

