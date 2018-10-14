<?php
declare(strict_types=1);

namespace Lotus\Core\Domain\Event;

interface EventInterface
{
    /**
     * Get unique identifier of event
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Get propagation stopped flag
     *
     * @return bool
     */
    public function getPropagationStopped(): bool;

    /**
     * Set propagation stopped flag
     *
     * @param bool $propagationStopped
     * @return EventInterface
     */
    public function setPropagationStopped(bool $propagationStopped): EventInterface;
}
