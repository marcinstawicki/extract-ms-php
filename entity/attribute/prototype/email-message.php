<?php
namespace MsPhp\Entity\Attribute\Prototype;

class EmailMessage extends Message {

    protected $encoding = '8bit';
    protected $charset = 'UTF-8';
    protected $files = [];
    protected $replyTo;
    protected $bodySet;
    protected $filesSet;
    protected $channel;
    protected $alternative;
    protected $mixed;
    protected $plain;
    protected $html;
    protected $headerSmtp;
    protected $subHeader;
    protected $label = '';
    protected $result = '';

    public function __construct() {
        $this->setBoundaries();
    }
    public function setReplyTo($address) {
        $this->replyTo = $address;
        return $this;
    }
    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }
    public function getLabel() {
        return $this->label;
    }
    public function setSubject($subject) {
        $this->subject = $this->charset == 'UTF-8' ? '=?UTF-8?B?' . base64_encode($subject) . '?=' : $subject;
        return $this;
    }
    public function addFile($filename) {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimetype = $finfo->file($filename);
        $content = file_get_contents($filename);
        $newcontent = chunk_split(base64_encode($content));
        $this->files[$filename] = array($mimetype, $newcontent);
        return $this;
    }

    private function setBodySet() {
        $body = $this->setHeaderSmtp()->headerSmtp . PHP_EOL . PHP_EOL;
        $body.= $this->setPlain()->plain;
        $body.= PHP_EOL . PHP_EOL;
        if (strpos($this->body, '</') !== false) {
            $body.= $this->setHtml()->html;
            $body.= PHP_EOL . PHP_EOL;
        }
        $body.= '--' . $this->alternative . '--';
        $body.= PHP_EOL . PHP_EOL;
        $this->bodySet = $body;
        return $this;
    }
    private function setPlain() {
        $body = $this->setSubHeader('plain')->subHeader;
        $body.= PHP_EOL . PHP_EOL;
        $body.= wordwrap(strip_tags($this->body), 200);
        $this->plain = $body;
        return $this;
    }
    private function setHtml() {
        $html = strpos($this->body, '<html>') === false ? $this->wrapHtml() : $this->body;
        $body = $this->setSubHeader('html')->subHeader;
        $body.= PHP_EOL . PHP_EOL;
        $body.= $html;
        $this->html = $body;
        return $this;
    }
    private function wrapHtml() {
        $body = '<html><head><title>Email</title></head><body>';
        $body.= nl2br($this->body);
        $body.= '</body></html>';
        return $body;
    }
    private function setHeaderSmtp() {
        $header = 'MIME-Version: 1.0' . PHP_EOL;
        $header.= 'Content-Type: multipart/mixed; boundary="' . $this->mixed . '"' . PHP_EOL . PHP_EOL;
        $header.= '--' . $this->mixed . PHP_EOL;
        $header.= 'Content-Type: multipart/alternative; boundary="' . $this->alternative . '"';
        $this->headerSmtp = $header;
        return $this;
    }
    private function setFilesSet() {
        $files = '';
        foreach ($this->files as $filename => $params) {
            list($mimetype, $content) = $params;
            $files.= $this->setSubHeader('attachment', $filename, $mimetype)->subHeader;
            $files.= PHP_EOL . PHP_EOL;
            $files.= $content;
            $files.= PHP_EOL . PHP_EOL;
        }
        $files.= '--' . $this->mixed . '--' . PHP_EOL;
        $this->filesSet = $files;
        return $this;
    }
    private function setBoundaries() {
        $hash = md5(uniqid());
        $this->alternative = 'MAILER-alternative-' . $hash;
        $this->mixed = 'MAILER-mixed-' . $hash;
    }
    private function setSubHeader($type, $filename = null, $mimetype = null) {
        $subHeader = '';
        switch ($type) {
            case 'plain':
            case 'html';
                $subHeader.= '--' . $this->alternative . PHP_EOL;
                $subHeader.= 'Content-Type: text/' . $type . '; charset="' . $this->charset . '"' . PHP_EOL;
                $subHeader.= 'Content-Transfer-Encoding: ' . $this->encoding;
                break;
            case 'attachment':
                if (is_null($filename)) {
                    die();
                }
                if (is_null($mimetype)) {
                    die();
                }
                $subHeader.= '--' . $this->mixed . PHP_EOL;
                $subHeader.= 'Content-Type: ' . $mimetype . '; name="' . $filename . '"' . PHP_EOL;
                $subHeader.= 'Content-Transfer-Encoding: base64' . PHP_EOL;
                $subHeader.= 'Content-Disposition: attachment; filename="' . $filename . '"';
                break;
            default:
                break;
        }
        $this->subHeader = $subHeader;
        return $this;
    }

    public function setResult() {
        $result = $this->setBodySet()->bodySet;
        $result.= $this->setFilesSet()->filesSet;
        $this->result = $result;
    }

    public function getResult(): string
    {
        return $this->result;
    }
}
