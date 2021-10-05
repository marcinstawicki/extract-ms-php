<?php
namespace MsPhp\VCalendar\Entity;

/**
 * vEvent is not supported by microsoft
 */
class VTodo extends VJournal {
    /**
     * @var $completed
     * COMPLETED:19960401T150000Z
     */
    protected $completed;
    /**
     * @var $percentComplete
     * PERCENT-COMPLETE:39
     */
    protected $percent_complete;
    protected $geo;
    protected $location ;
    /**
     * @var $priority: Must be in the range [0..9]
     * PRIORITY:2
     */
    protected $priority;
    protected $duration;
    /**
     * @var $due
     * DUE:19980430T000000Z
     */
    protected $due;
    const STATUS_TD_NEEDS_ACTION = 'NEEDS-ACTION';
    const STATUS_TD_COMPLETED = 'COMPLETED';
    const STATUS_TD_IN_PROCESS = 'IN-PROCESS';
    const STATUS_TD_CANCELLED = 'CANCELLED';
    /**
     * @var $resources
     * RESOURCES:EASEL,PROJECTOR,VCR
     * RESOURCES;LANGUAGE=fr:Nettoyeur haute pression
     */
    protected $resources;

    public function setDateTimeCompleted($completed) {
        $this->completed = $completed;
        return $this;
    }
    public function setPercentComplete($percent_complete) {
        $this->percent_complete = $percent_complete;
        return $this;
    }
    public function setGeologicalPosition($geo) {
        $this->geo = $geo;
        return $this;
    }
    public function setLocation($location) {
        $this->location = $location;
        return $this;
    }
    public function setPriority($priority) {
        $this->priority = $priority;
        return $this;
    }
    public function setDuration($duration) {
        $this->duration = $duration;
        return $this;
    }
    public function setDateTimeDue($due) {
        $this->due = $due;
        return $this;
    }
    public function setResources($resources) {
        $this->resources = $resources;
        return $this;
    }
}
