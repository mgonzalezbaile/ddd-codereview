<?php

declare(strict_types=1);

namespace CodeReview\Domain\Exception;

class AssignReviewerException extends \DomainException
{
    public static function becauseReviewerAlreadyAssigned(string $pullRequestId, string $reviewer)
    {
        return new self("Reviewer $reviewer was already assigned to Pull Request $pullRequestId");
    }
}
