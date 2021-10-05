<?php
namespace MsPhp\VCalendar\Entity;

class VAlarm extends VComponent {
    /**
     * BEGIN:VALARM
     * TRIGGER;RELATED=END:-P2D
     * ACTION:EMAIL
     * ATTENDEE:mailto:john_doe@example.com
     * SUMMARY:*** REMINDER: SEND AGENDA FOR WEEKLY STAFF MEETING ***
     * DESCRIPTION:A draft agenda needs to be sent out to the attendees
     * to the weekly managers meeting (MGR-LIST). Attached is a
     * pointer the document template for the agenda file.
     * ATTACH;FMTTYPE=application/msword:http://example.com/
     * templates/agenda.doc
     * END:VALARM
     */
    /**
     * @var $action
     * ACTION:DISPLAY
     */
    protected $action;
    const ACTION_AUDIO = 'AUDIO';
    const ACTION_DISPLAY = 'DISPLAY';
    const ACTION_EMAIL = 'EMAIL';
    /**
     * @var $trigger
     * TRIGGER:-PT15M
     * TRIGGER;RELATED=END:PT5M
     * TRIGGER;VALUE=DATE-TIME:19980101T050000Z
     */
    protected $trigger;
    /**
     * @var $duration
     * DURATION:PT5M
     */
    protected $duration;
    protected $summary;
    protected $description;
    protected $attendee;
    /**
     * @var $repeat
     * REPEAT:4
     */
    protected $repeat;
    protected $attach;

    public function setAction($action = self::ACTION_DISPLAY) {
        $this->action = $action;
        return $this;
    }
    public function setTrigger($trigger) {
        $this->trigger = $trigger;
        return $this;
    }
    public function setDuration($duration) {
        $this->duration = $duration;
        return $this;
    }
    public function setSummary($summary) {
        $this->summary = $summary;
        return $this;
    }
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }
    public function setAttendee($attendee) {
        $this->attendee = $attendee;
        return $this;
    }
    public function setRepeat($repeat) {
        $this->repeat = $repeat;
        return $this;
    }
    public function setAttachment($attach) {
        $this->attach = $attach;
        return $this;
    }
}
