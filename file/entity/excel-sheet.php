<?php
namespace MsPhp\File\Entity;

class ExcelSheet extends FileType {
    
    protected $head;
    protected $body;
    protected $begin;
    protected $data;
    protected $end;
    protected $cell;
    protected $result;

    public function __construct(array $data) {
        parent::__construct();
        $this->data = $data;
    }
    public function setResult() {
        $result = $this->setBegin()->begin;
        $result.= $this->setHead()->head;
        $result.= $this->setBody()->body;
        $result.= $this->setEnd()->end;
        $this->result = $result;
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
    protected function setHead() {
        if (!empty($this->data)) {
            $head = '';
            $row = 0;
            foreach ($this->data[$row] as $column => $value) {
                $head.= $this->setCell($row, (int) $column, $value)->cell;
            }
            $this->head = $head;
        }
        return $this;
    }
    protected function setBody() {
        if (!empty($this->data)) {
            $body = '';
            $row = 1;
            while ($this->data[$row]) {
                foreach ($this->data[$row] as $column => $value) {
                    $body.= $this->setCell($row, (int) $column, $value)->cell;
                }
                $row++;
            }
            $this->body = $body;
        }
        return $this;
    }
    protected function setBegin() {
        $this->begin = pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
        return $this;
    }
    protected function setEnd() {
        $this->end = pack("ss", 0x0A, 0x00);
        return $this;
    }
    protected function setCell($row, $column, $value) {
        if (is_numeric($value)) {
            $cell = pack("sssss", 0x203, 14, $row, $column, 0x0);
            $cell.= pack("d", $value);
        } else {
            $length = strlen($value);
            $cell = pack("ssssss", 0x204, 8 + $length, $row, $column, 0x0, $length);
            $cell.= $value;
        }
        $this->cell = $cell;
        return $this;
    }
}

/*$data = [];
$excel = (new \MsPhp\File\ExcelSheet($data))->setResult();
$file = new \MsPhp\App\Storage\File('my.xls');
$file->storeString($excel->getResult());*/



