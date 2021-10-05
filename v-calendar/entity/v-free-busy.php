<?php
namespace MsPhp\VCalendar\Entity;

class VFreeBusy {
    /**
     * todo: finish it!
     */
    /**
     * BEGIN:VFREEBUSY
     * UID:19970901T082949Z-FA43EF@example.com
     * ORGANIZER:mailto:jane_doe@example.com
     * ATTENDEE:mailto:john_public@example.com
     * DTSTART:19971015T050000Z
     * DTEND:19971016T050000Z
     * dateTimeStamp:19970901T083000Z
     * END:VFREEBUSY
     *
     *
     * BEGIN:VFREEBUSY
     * UID:19970901T115957Z-76A912@example.com
     * dateTimeStamp:19970901T120000Z
     * ORGANIZER:jsmith@example.com
     * DTSTART:19980313T141711Z
     * DTEND:19980410T141711Z
     * FREEBUSY:19980314T233000Z/19980315T003000Z
     * FREEBUSY:19980316T153000Z/19980316T163000Z
     * FREEBUSY:19980318T030000Z/19980318T040000Z
     * URL:http://www.example.com/calendar/busytime/jsmith.ifb
     * END:VFREEBUSY
     */
    protected $uId;
    protected $dateTimeStamp;
    protected $dateTimeStart;
    protected $dateTimeEnd;
    protected $organizer;
    protected $url;
    protected $attendee;
    protected $comment;
    protected $contact;
    protected $requestStatus;
    protected $result;

    public function setUId($uId) {
        $this->uId = $uId;
        return $this;
    }
    public function setDateTimeStamp($dateTimeStamp) {
        $this->dateTimeStamp = $dateTimeStamp;
        return $this;
    }
    public function setDateTimeStart($dateTimeStart) {
        $this->dateTimeStart = $dateTimeStart;
        return $this;
    }
    public function setDateTimeEnd($dateTimeEnd) {
        $this->dateTimeEnd = $dateTimeEnd;
        return $this;
    }
    public function setOrganizer($organizer) {
        $this->organizer = $organizer;
        return $this;
    }
    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }
    public function setAttendee($attendee) {
        $this->attendee = $attendee;
        return $this;
    }
    public function setComment($comment) {
        $this->comment = $comment;
        return $this;
    }
    public function setContact($contact) {
        $this->contact = $contact;
        return $this;
    }
    public function setRequestStatus($requestStatus) {
        $this->requestStatus = $requestStatus;
        return $this;
    }
    public function getResult() {
        return $this->result;
    }
    public function setResult($result) {
        $this->result = $result;
        return $this;
    }
}
