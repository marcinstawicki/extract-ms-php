<?php
namespace MsPhp\VCalendar\Entity;

class VJournal extends VComponent {
    /**
     * BEGIN:VJOURNAL
     * UID:19970901T130000Z-123405@example.com
     * dateTimeStamp:19970901T130000Z
     * DTSTART;VALUE=DATE:19970317
     * SUMMARY:Staff meeting minutes
     * DESCRIPTION:1. Staff meeting: Participants include Joe\,
     * Lisa\, and Bob. Aurora project plans were reviewed.
     * There is currently no budget reserves for this project.
     * Lisa will escalate to management. Next meeting on Tuesday.\n
     * 2. Telephone Conference: ABC Corp. sales representative
     * called to discuss new printer. Promised to get us a demo by
     * Friday.\n3. Henry Miller (Handsoff Insurance): Car was
     * totaled by tree. Is looking into a loaner car. 555-2323
     * (tel).
     * END:VJOURNAL
     */
    protected $uid;
    protected $dtstamp;
    protected $dtstart;
    protected $class;
    const CLASS_PUBLIC = 'PUBLIC';
    const CLASS_PRIVATE = 'PRIVATE';
    const CLASS_CONFIDENTIAL = 'CONFIDENTIAL';
    protected $created;
    protected $description;
    protected $last_modified;
    /**
     * @var $organizer
     * ORGANIZER;CN=John Smith:mailto:jsmith@example.com
     * ORGANIZER;SENT-BY="mailto:jane_doe@example.com": mailto:jsmith@example.com
     */
    protected $organizer;
    protected $sequence;

    protected $status;
    const STATUS_JO_DRAFT = 'DRAFT';
    const STATUS_JO_FINAL = 'FINAL';
    const STATUS_JO_CANCELLED = 'CANCELLED';
    protected $summary;
    protected $url;
    protected $recurrence_id;
    /**
     * @var $rrule
     * DTSTART;TZID=America/New_York:19970902T090000
     * RRULE:FREQ=DAILY;INTERVAL=2
     * RRULE:FREQ=DAILY;INTERVAL=10;COUNT=5
     * RRULE:FREQ=YEARLY;UNTIL=20000131T140000Z;BYMONTH=1;BYDAY=SU,MO,TU,WE,TH,FR,SA
     * RRULE:FREQ=DAILY;UNTIL=20000131T140000Z;BYMONTH=1
     */
    protected $rrule;
    protected $attach;
    /**
     * @var $attendee
     * ATTENDEE;MEMBER="mailto:DEV-GROUP@example.com": mailto:joecool@example.com
     * ATTENDEE;DELEGATED-FROM="mailto:immud@example.com": mailto:ildoit@example.com
     * ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=TENTATIVE;CN=Henry Cabot:mailto:hcabot@example.com
     * ATTENDEE;ROLE=REQ-PARTICIPANT;DELEGATED-FROM="mailto:bob@example.com";PARTSTAT=ACCEPTED;CN=Jane Doe:mailto:jdoe@example.com
     */
    protected $attendee;
    const CATEGORY_ANNIVERSARY = 'ANNIVERSARY';
    const CATEGORY_APPOINTMENT = 'APPOINTMENT';
    const CATEGORY_BUSINESS = 'BUSINESS';
    const CATEGORY_EDUCATION = 'EDUCATION';
    const CATEGORY_HOLIDAY = 'HOLIDAY';
    const CATEGORY_MEETING = 'MEETING';
    const CATEGORY_MISCELLANEOUS = 'MISCELLANEOUS';
    const CATEGORY_NON_WORKING_HOURS = 'NON-WORKING HOURS';
    const CATEGORY_NOT_IN_OFFICE = 'NOT IN OFFICE';
    const CATEGORY_PERSONAL = 'PERSONAL';
    const CATEGORY_PHONE_CALL = 'PHONE CALL';
    const CATEGORY_SICK_DAY = 'SICK DAY';
    const CATEGORY_SPECIAL_OCCASION = 'SPECIAL OCCASION';
    const CATEGORY_TRAVEL = 'TRAVEL';
    const CATEGORY_VACATION = 'VACATION';
    protected $categories;
    protected $comment;
    /**
     * @var $contact
     * CONTACT:Jim Dolittle\, ABC Industries\, +1-919-555-1234
     * CONTACT;ALTREP="ldap://example.com:6666/o=ABC%20Industries\, c=US???(cn=Jim%20Dolittle)":Jim Dolittle\, ABC Industries\, +1-919-555-1234
     * CONTACT;ALTREP="http://example.com/pdi/jdoe.vcf":Jim Dolittle\, ABC Industries\, +1-919-555-1234
     */
    protected $contact;
    /**
     * @var $exdate
     * EXDATE:19960402T010000Z,19960403T010000Z,19960404T010000Z
     */
    protected $exdate;
    protected $request_status;
    /**
     * @var
     * RELATED-TO:<jsmith.part7.19960817T083000.xyzMail@host3.com>
     * RELATED-TO:<19960401-080045-4000F192713-0052@host1.com>
     */
    protected $related_to;
    /**
     * @var $rdate
     * RDATE:19970714T123000Z
     * RDATE;TZID=America/New_York:19970714T083000
     * RDATE;VALUE=PERIOD:19960403T020000Z/19960403T040000Z,19960404T010000Z/PT3H
     * RDATE;VALUE=DATE:19970101,19970120,19970217,19970421,19970526,19970704,19970901,19971014,19971128,19971129,19971225
     */
    protected $rdate;

    public function setUId($uid) {
        $this->uid = $uid;
        return $this;
    }
    public function setDateTimeStamp($dtstamp) {
        $this->dtstamp = $dtstamp;
        return $this;
    }
    public function setDateTimeStart($dtstart) {
        $this->dtstart = $dtstart;
        return $this;
    }
    public function setClassification($class) {
        $this->class = $class;
        return $this;
    }
    public function setDateTimeCreated($created) {
        $this->created = $created;
        return $this;
    }
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }
    public function setLastModified($last_modified) {
        $this->last_modified = $last_modified;
        return $this;
    }
    public function setOrganizer($organizer) {
        $this->organizer = $organizer;
        return $this;
    }
    public function setSequenceNumber($sequence) {
        $this->sequence = $sequence;
        return $this;
    }
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }
    public function setSummary($summary) {
        $this->summary = $summary;
        return $this;
    }
    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }
    public function setRecurrenceId($recurrence_id) {
        $this->recurrence_id = $recurrence_id;
        return $this;
    }
    public function setRecurrenceRule($rrule) {
        $this->rrule = $rrule;
        return $this;
    }
    public function setAttachment($attach) {
        $this->attach = $attach;
        return $this;
    }
    public function setAttendee($attendee) {
        $this->attendee = $attendee;
        return $this;
    }
    public function setCategories($categories) {
        $this->categories = $categories;
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
    public function setExceptionDateTime($exdate) {
        $this->exdate = $exdate;
        return $this;
    }
    public function setRequestStatus($request_status) {
        $this->request_status = $request_status;
        return $this;
    }
    public function setRelatedTo($related_to) {
        $this->related_to = $related_to;
        return $this;
    }
    public function setRecurrenceDate($rdate) {
        $this->rdate = $rdate;
        return $this;
    }
}
