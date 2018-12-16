<?php


namespace PullRequest\Domain;


use Soa\EventSourcing\Event\EventStream;

interface PullRequestRepository
{
    public function saveEventStream(EventStream $eventStream): void;
}
