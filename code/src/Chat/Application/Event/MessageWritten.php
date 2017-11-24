<?php

namespace Gambling\Chat\Application\Event;

use Gambling\Common\Domain\DomainEvent;

final class MessageWritten implements DomainEvent
{
    /**
     * @var string
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
    private $occurredOn;

    /**
     * MessageWritten constructor.
     *
     * @param string $chatId
     * @param int    $messageId
     * @param string $ownerId
     * @param string $authorId
     * @param string $message
     */
    public function __construct(
        string $chatId,
        int $messageId,
        string $ownerId,
        string $authorId,
        string $message
    ) {
        $this->chatId = $chatId;
        $this->messageId = $messageId;
        $this->ownerId = $ownerId;
        $this->authorId = $authorId;
        $this->message = $message;
        $this->occurredOn = new \DateTimeImmutable();
    }


    /**
     * @inheritdoc
     */
    public function name(): string
    {
        return 'chat.message-written';
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
    public function payload(): array
    {
        return [
            'chatId'    => $this->chatId,
            'messageId' => $this->messageId,
            'ownerId'   => $this->ownerId,
            'authorId'  => $this->authorId,
            'message'   => $this->message
        ];
    }
}