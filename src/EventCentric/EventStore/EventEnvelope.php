<?php

namespace EventCentric\EventStore;

use EventCentric\Contracts\Contract;
use Assert;
use EventCentric\EventStore\EventId;

/**
 * An EventEnvelope wraps a payload with a bunch of relevant information, so we can send it around.
 */
final class EventEnvelope
{
    /**
     * @var EventId
     */
    private $eventId;

    /**
     * @var Contract
     */
    private $eventContract;

    /**
     * @var $eventPayload
     */
    private $eventPayload;

    private function __construct(){}

    /**
     * @param EventId $eventId
     * @param Contract $eventContract
     * @param string $eventPayload
     * @return EventEnvelope
     */
    public static function wrap(EventId $eventId, Contract $eventContract, $eventPayload)
    {
        Assert\that($eventPayload)->string();
        $eventEnvelope = new EventEnvelope;
        $eventEnvelope->eventId = $eventId;
        $eventEnvelope->eventContract = $eventContract;
        $eventEnvelope->eventPayload = $eventPayload;
        return $eventEnvelope;
    }

    public static function reconstitute(
        EventId $eventId,
        Contract $eventContract,
        $eventPayload
    )
    {
        $eventEnvelope = new EventEnvelope();
        $eventEnvelope->eventId = $eventId;
        $eventEnvelope->eventContract = $eventContract;
        $eventEnvelope->eventPayload = $eventPayload;
        return $eventEnvelope;
    }

    /**
     * @return Contract
     */
    public function getEventContract()
    {
        return $this->eventContract;
    }

    /**
     * @return string
     */
    public function getEventPayload()
    {
        return $this->eventPayload;
    }

    /**
     * @return EventId
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    public function equals(EventEnvelope $other)
    {
        return
            $this->eventId->equals($other->eventId)
            && $this->eventContract->equals($other->eventContract)
            && $this->eventPayload == $other->eventPayload;
    }
} 