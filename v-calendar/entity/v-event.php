<?php
namespace MsPhp\VCalendar\Entity;

class VEvent extends VJournal {
    /**
     * BEGIN:VEVENT
     * UID:19970901T130000Z-123401@example.com
     * dateTimeStamp:19970901T130000Z
     * DTSTART:19970903T163000Z
     * DTEND:19970903T190000Z
     * SUMMARY:Annual Employee Review
     * CLASS:PRIVATE
     * CATEGORIES:BUSINESS,HUMAN RESOURCES
     * TRANSP:TRANSPARENT
     * END:VEVENT
     */
    /**
     * @var $geo
     * GEO:37.386013;-122.082932
     */
    protected $geo;
    /**
     * @var $location
     * LOCATION;ALTREP="http://xyzcorp.com/conf-rooms/f123.vcf":
     * Conference Room - F123\, Bldg. 002
     */
    protected $location;
    /**
     * @var
     * [1-9]
     */
    protected $priority;
    /**
     * @var $trasp
     */
    protected $transp;
    const TIME_TRANSPARENCY_OPAQUE = 'OPAQUE';
    const TIME_TRANSPARENCY_TRANSPARENT = 'TRANSPARENT';
    /**
     * @var $dtend
     * DTEND:19960401T150000Z
     * DTEND;VALUE=DATE:19980704
     */
    protected $dtend;
    /**
     * @var $duration
     * DURATION:PT1H0M0S
     * DURATION:PT15M
     */
    protected $duration;
    /**
     * @var $resources
     * RESOURCES:EASEL,PROJECTOR,VCR
     * RESOURCES;LANGUAGE=fr:Nettoyeur haute pression
     */
    protected $resources;
    const STATUS_EV_TENTATIVE = 'TENTATIVE';
    const STATUS_EV_CONFIRMED = 'CONFIRMED';
    const STATUS_EV_CANCELLED = 'CANCELLED';

    public function setGeographicPosition($geo) {
        $this->geo = $geo;
        return $this;
    }
    public function setLocation($location) {
        $this->location = $location;
        return $this;
    }
    public function setPriority(int $priority) {
        $this->priority = $priority;
        return $this;
    }
    public function setTimeTransparency($transp) {
        $this->transp = $transp;
        return $this;
    }
    public function setDateTimeEnd($dtend) {
        $this->dtend = $dtend;
        return $this;
    }
    public function setDuration($duration) {
        $this->duration = $duration;
        return $this;
    }
    public function setResources($resources) {
        $this->resources = $resources;
        return $this;
    }
}
