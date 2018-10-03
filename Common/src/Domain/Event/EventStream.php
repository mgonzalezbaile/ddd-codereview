<?php

declare(strict_types=1);

namespace Common\Domain\Event;

class EventStream implements \Countable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var DomainEvent
     */
    private $domainEvents;

    public static function fromDomainEvents(DomainEvent ...$domainEvents): self
    {
        return new self(...$domainEvents);
    }

    private function __construct(DomainEvent ...$domainEvents)
    {
        $this->domainEvents = $domainEvents;
        $this->id           = $this->extractStreamId(...$domainEvents);
    }

    private function extractStreamId(DomainEvent ...$domainEvents): string
    {
        return (string) array_reduce(
            $domainEvents,
            function (string $previousId, DomainEvent $domainEvent) {
                if ($previousId !== $domainEvent->streamId()) {
                    throw new \InvalidArgumentException('Event Stream must consist of events from the same Aggregate Root');
                }

                return $previousId;
            },
            array_pop($domainEvents)->streamId()
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function count(): int
    {
        return count($this->domainEvents);
    }

    /**
     * @return DomainEvent[]
     */
    public function domainEvents(): array
    {
        return $this->domainEvents;
    }
}
