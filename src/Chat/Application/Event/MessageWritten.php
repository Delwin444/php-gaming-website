<?php
declare(strict_types=1);

namespace Gaming\Chat\Application\Event;

use Gaming\Chat\Application\ChatId;
use Gaming\Common\Clock\Clock;
use Gaming\Common\Domain\DomainEvent;

final class MessageWritten implements DomainEvent
{
    /**
     * @var ChatId
     */
    private $chatId;

    /**
     * @var int
     */
    private $messageId;

    /**
     * @var string
     */
    private $ownerId;

    /**
     * @var string
     */
    private $authorId;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTimeImmutable
     */
    private $writtenAt;

    /**
     * @var \DateTimeImmutable
     */
    private $occurredOn;

    /**
     * MessageWritten constructor.
     *
     * @param ChatId             $chatId
     * @param int                $messageId
     * @param string             $ownerId
     * @param string             $authorId
     * @param string             $message
     * @param \DateTimeImmutable $writtenAt
     */
    public function __construct(
        ChatId $chatId,
        int $messageId,
        string $ownerId,
        string $authorId,
        string $message,
        \DateTimeImmutable $writtenAt
    ) {
        $this->chatId = $chatId;
        $this->messageId = $messageId;
        $this->ownerId = $ownerId;
        $this->authorId = $authorId;
        $this->message = $message;
        $this->writtenAt = $writtenAt;
        $this->occurredOn = Clock::instance()->now();
    }

    /**
     * @inheritdoc
     */
    public function name(): string
    {
        return 'MessageWritten';
    }

    /**
     * @inheritdoc
     */
    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    /**
     * @inheritdoc
     */
    public function aggregateId(): string
    {
        return $this->chatId->toString();
    }

    /**
     * @inheritdoc
     */
    public function payload(): array
    {
        return [
            'chatId'    => $this->chatId->toString(),
            'messageId' => $this->messageId,
            'ownerId'   => $this->ownerId,
            'authorId'  => $this->authorId,
            'message'   => $this->message,
            'writtenAt' => $this->writtenAt->format(\DateTime::ATOM)
        ];
    }
}
