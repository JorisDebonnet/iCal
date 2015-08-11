<?php

namespace Eluceo\iCal\Property\Event;

use Eluceo\iCal\ParameterBag;
use Eluceo\iCal\Property;
use Eluceo\iCal\Util\DateUtil;
use Eluceo\iCal\Property\ValueInterface;

/**
 * Implementation of Recurrence Id.
 *
 * @see http://www.ietf.org/rfc/rfc2445.txt 4.8.4.4 Recurrence ID
 */
class RecurrenceId extends Property
{
    const PROPERTY_NAME = 'RECURRENCE-ID';

    /**
     * The effective range of recurrence instances from the instance
     * specified by the recurrence identifier specified by the property.
     */
    const RANGE_THISANDPRIOR = 'THISANDPRIOR';
    const RANGE_THISANDFUTURE = 'THISANDFUTURE';

    /**
     * The dateTime to identify a particular instance of a recurring event which is getting modified.
     *
     * @var \DateTime
     */
    protected $dateTime;

    public function __construct(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
        $this->parameterBag = new ParameterBag();
    }

    public function applyTimeSettings($noTime = false, $useTimezone = false, $useUtc = false)
    {
        $params = DateUtil::getDefaultParams($this->dateTime, $noTime, $useTimezone, $useUtc);
        foreach ($params as $name => $value) {
            $this->parameterBag->setParam($name, $value);
        }

        $this->setValue(DateUtil::getDateString($this->dateTime, $noTime, $useTimezone, $useUtc));
    }

    /**
     * @return DateTime
     */
    public function getDatetime()
    {
        return $this->dateTime;
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return \Eluceo\iCal\Property\Event\RecurrenceId
     */
    public function setDatetime(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * @param string $range
     *
     * @return \Eluceo\iCal\Property\Event\RecurrenceId
     */
    public function setRange($range)
    {
        $this->parameterBag->setParam('RANGE', $range);
    }

    /**
     * Get all unfolded lines.
     *
     * @return array
     */
    public function toLines()
    {
        if (!$this->value instanceof ValueInterface) {
            throw new \Exception('The value must implement the ValueInterface. Call RecurrenceId::applyTimeSettings() before adding RecurrenceId.');
        } else {
            return parent::toLines();
        }
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return self::PROPERTY_NAME;
    }
}
