<?php
declare(strict_types=1);

namespace Lotus\Core\Infrastructure\Event;

use Lotus\Core\Domain\Event\DispatcherInterface;
use Lotus\Core\Domain\Event\EventInterface;

/**
 * This class is reference from Symfony\Event\EventDispatcher
 *
 * Class Dispatcher
 * @package Lotus\Core\Infrastructure\Event
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var array
     */
    protected $listeners = [];

    /**
     * @var array
     */
    protected $sorted = [];

    /**
     * {@inheritdoc}
     *
     * @param EventInterface $event
     * @return EventInterface
     */
    public function dispatch(EventInterface $event): EventInterface
    {
        if ($listeners = $this->getListeners($event->getId())) {
            $this->doDispatch($listeners, $event);
        }

        return $event;
    }

    /**
     * Triggers the listeners of an event.
     *
     * This method can be overridden to add functionality that is executed
     * for each listener.
     *
     * @param callable[] $listeners The event listeners
     * @param EventInterface $event The event object to pass to the event handlers/listeners
     */
    protected function doDispatch($listeners, EventInterface $event)
    {
        foreach ($listeners as $listener) {
            if ($event->getPropagationStopped()) {
                break;
            }
            \call_user_func($listener, $event, $this);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param EventInterface $event
     * @param callable $listener
     * @param int $priority
     */
    public function addListener(EventInterface $event, $listener, $priority = 0): void
    {
        $this->listeners[$event->getId()][$priority][] = $listener;
        unset($this->sorted[$event->getId()]);
    }

    /**
     * {@inheritdoc}
     *
     * @param string|null $eventId
     * @return array
     */
    public function getListeners(string $eventId = null): array
    {
        if (null !== $eventId) {
            if (empty($this->listeners[$eventId])) {
                return [];
            }

            if (!isset($this->sorted[$eventId])) {
                $this->sortListeners($eventId);
            }

            return $this->sorted[$eventId];
        }

        foreach ($this->listeners as $eventId => $eventListeners) {
            if (!isset($this->sorted[$eventId])) {
                $this->sortListeners($eventId);
            }
        }

        return array_filter($this->sorted);
    }

    /**
     * Sorts the internal list of listeners for the given event by priority.
     *
     * @param string $eventId
     */
    protected function sortListeners(string $eventId): void
    {
        krsort($this->listeners[$eventId]);
        $this->sorted[$eventId] = [];

        foreach ($this->listeners[$eventId] as $priority => $listeners) {
            foreach ($listeners as $k => $listener) {
                if (\is_array($listener) && isset($listener[0]) && $listener[0] instanceof \Closure) {
                    $listener[0] = $listener[0]();
                    $this->listeners[$eventId][$priority][$k] = $listener;
                }
                $this->sorted[$eventId][] = $listener;
            }
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param string $eventName
     * @param callable $listener
     * @return int
     */
    public function getListenerPriority($eventId, $listener): int
    {
        if (empty($this->listeners[$eventId])) {
            return 0; // todo: should zero or -1
        }

        if (\is_array($listener) && isset($listener[0]) && $listener[0] instanceof \Closure) {
            $listener[0] = $listener[0]();
        }

        foreach ($this->listeners[$eventId] as $priority => $listeners) {
            foreach ($listeners as $k => $v) {
                if ($v !== $listener && \is_array($v) && isset($v[0]) && $v[0] instanceof \Closure) {
                    $v[0] = $v[0]();
                    $this->listeners[$eventId][$priority][$k] = $v;
                }
                if ($v === $listener) {
                    return $priority;
                }
            }
        }

        return 0; // todo: should zero or -1
    }

    /**
     * {@inheritdoc}
     *
     * @param null $eventId
     * @return bool
     */
    public function hasListeners($eventId = null)
    {
        if (null !== $eventId) {
            return !empty($this->listeners[$eventId]);
        }

        foreach ($this->listeners as $eventListeners) {
            if ($eventListeners) {
                return true;
            }
        }

        return false;
    }
}
