<?php
declare(strict_types=1);

namespace Lotus\Core\Infrastructure\Event;

use Lotus\Core\Domain\Event\EventInterface;

class Event implements EventInterface
{
    /**
     * @var bool
     */
    protected $propagationStopped = false;

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getId(): string
    {
        return get_class($this);
    }

    /**
     * {@inheritdoc}
     *
     * @return bool
     */
    public function getPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    /**
     * {@inheritdoc}
     *
     * @param bool $propagationStopped
     * @return EventInterface
     */
    public function setPropagationStopped(bool $propagationStopped): EventInterface
    {
        $this->propagationStopped = $propagationStopped;
        return $this;
    }
}
