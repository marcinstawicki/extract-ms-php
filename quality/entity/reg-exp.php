<?php
namespace MsPhp\Quality\Entity;

use MsPhp\App\Entity\Env;

abstract class RegExp extends Custom {
    protected $basic_latin_letters = '\x{0041}-\x{005A}\x{0061}-\x{007A}';
    protected $basicLettersLabel = 'basic letters (EN)';
    protected $basic_latin_numbers = '\x{0030}-\x{0039}';
    protected $basicNumbersLabel = 'digits';
    protected $basic_latin_special_characters = '\x{0021}-\x{002F}\x{003A}-\x{0040}\x{005B}-\x{0060}\x{007B}-\x{007E}';
    protected $basicSpecialCharactersLabel = '!"#$%&\'()*+,-./  :,<=>?@  [\\]^_  {|}~';
    protected $space = '\x{0020}';
    protected $spaceLabel = 'space';
    protected $latin_1_supplement_letters = '\x{00C0}-\x{00D6}\x{00D8}-\x{00F6}\x{00F8}-\x{00FF}';
    protected $latin_1_supplement_special_characters = '\x{00A1}-\x{00BF}';
    protected $extendedSpecialCharactersLabel = 'special characters';
    protected $latin_extended_a = '\x{0100}-\x{017F}';
    protected $latin_extended_b = '\x{0180}-\x{01FF}';
    protected $cyrillic = '\x{0400}-\x{047F}';
    protected $cyrillic_supplement = '\x{0500}-\x{057F}';
    protected $extendedLettersLabel = 'letters';

    public function setResult() {
        foreach($this->labels as &$label){
            $label = Env::translation($label);
        }
        $this->message = implode(', ',$this->labels);
        if(!is_array($this->isValue)){
            $this->isValue = [$this->isValue];
        }
        $result = true;
        foreach($this->isValue as $isValue){
            $match = preg_match("/" . $this->shallValue . "/u", $isValue);
            if($match === false){
                $result = false;
                break;
            } else if($match === 0) {
                $result = false;
                break;
            }
        }
        $this->result = $result;
        return $this;
    }
}
