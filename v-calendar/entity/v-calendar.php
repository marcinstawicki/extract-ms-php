<?php
namespace MsPhp\VCalendar\Entity;

class VCalendar extends VComponent {
    /**
     * DESCRIPTION;
     * ATTENDEE;
     * DATE-TIME
     * DTSTART:19970714T133000
     * DTSTART:19970714T173000Z
     * DTSTART;TZID=America/New_York:19970714T133000
     * DTSTART;TZID=America/New_York:19970105T083000
     * RRULE:FREQ=YEARLY;INTERVAL=2;BYMONTH=1;BYDAY=SU;BYHOUR=8,9;
     * FREQ=MONTHLY;BYDAY=MO,TU,WE,TH,FR;BYSETPOS=-1
     * BYMINUTE=30
     *
     * BEGIN:VCALENDAR
     * VERSION:2.0
     * PRODID:-//hacksw/handcal//NONSGML v1.0//EN
     * BEGIN:VEVENT
     * UID:19970610T172345Z-AF23B2@example.com
     * dateTimeStamp:19970610T172345Z
     * DTSTART:19970714T170000Z
     * DTEND:19970715T040000Z
     * SUMMARY:Bastille Day Party
     * END:VEVENT
     * END:VCALENDAR
     *
     * BEGIN:VCALENDAR
     * PRODID:-//RDU Software//NONSGML HandCal//EN
     * VERSION:2.0
     * BEGIN:VTIMEZONE
     * TZID:America/New_York
     * BEGIN:STANDARD
     * DTSTART:19981025T020000
     * TZOFFSETFROM:-0400
     * TZOFFSETTO:-0500
     * TZNAME:EST
     * END:STANDARD
     * BEGIN:DAYLIGHT
     * DTSTART:19990404T020000
     * TZOFFSETFROM:-0500
     * TZOFFSETTO:-0400
     * TZNAME:EDT
     * END:DAYLIGHT
     * END:VTIMEZONE
     * BEGIN:VEVENT
     * dateTimeStamp:19980309T231000Z
     * UID:guid-1.example.com
     * ORGANIZER:mailto:mrbig@example.com
     * ATTENDEE;RSVP=TRUE;ROLE=REQ-PARTICIPANT;CUTYPE=GROUP:
     * mailto:employee-A@example.com
     * DESCRIPTION:Project XYZ Review Meeting
     * CATEGORIES:MEETING
     * CLASS:PUBLIC
     * CREATED:19980309T130000Z
     * SUMMARY:XYZ Project Review
     * DTSTART;TZID=America/New_York:19980312T083000
     * DTEND;TZID=America/New_York:19980312T093000
     * LOCATION:1CP Conference Room 4350
     * END:VEVENT
     * END:VCALENDAR
     *
     *
     * CALSCALE:GREGORIAN
     * METHOD:REQUEST
     * PRODID:-//ABC Corporation//NONSGML My Product//EN
     * VERSION:2.0
     */
    protected $calendarScale = 'GREGORIAN';
    const METHOD_REQUEST = 'REQUEST';
    protected $method;
    protected $productId = '//MS//BC/EN';
    protected $version = '2.0';
    protected $vComponents;

    public function setCalendarScale($calendarScale) {
        $this->calendarScale = $calendarScale;
        return $this;
    }
    public function setMethod($method) {
        $this->method = $method;
        return $this;
    }
    public function setProductId($productId) {
        $this->productId = $productId;
        return $this;
    }
    public function setVersion($version) {
        $this->version = $version;
        return $this;
    }
    public function addVComponent(VComponent $instance){
        $this->vComponents.= $instance->setResult()->getResult();
    }
}
