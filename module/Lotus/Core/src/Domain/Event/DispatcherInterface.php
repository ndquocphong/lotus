<?php
declare(strict_types=1);

namespace Lotus\Core\Domain\Event;

/**
 * This class reference to \Symfony\Component\EventDispatcher\EventDispatcherInterface
 */
interface DispatcherInterface
{
    /**
     * Execute listener's function on an event
     *
     * @param EventInterface $event
     * @return EventInterface
     */
    public function dispatch(EventInterface $event): EventInterface;

    /**
     * Adds an event listener that listens on the specified events.
     *
     * @param EventInterface $event The event to listen on
     * @param callable $listener The listener
     * @param int $priority The higher this value, the earlier an event listener will be triggered in the chain (defaults to 0)
     */
    public function addListener(EventInterface $event, $listener, $priority = 0): void ;

    /**
     * Gets the listeners of a specific event or all listeners sorted by descending priority.
     *
     * @param string $eventId The id of the event
     *
     * @return array The event listeners for the specified event, or all event listeners by event name
     */
    public function getListeners(string $eventId = null): array ;

    /**
     * Gets the listener priority for a specific event.
     *
     * Returns null if the event or the listener does not exist.
     *
     * @param string $eventId The name of the event
     * @param callable $listener  The listener
     *
     * @return int The event listener priority
     */
    public function getListenerPriority($eventId, $listener): int;

    /**
     * Checks whether an event has any registered listeners.
     *
     * @param string $eventId The name of the event
     *
     * @return bool true if the specified event has any listeners, false otherwise
     */
    public function hasListeners($eventId = null);
}
