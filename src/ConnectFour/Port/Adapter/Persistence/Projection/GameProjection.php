<?php
declare(strict_types=1);

namespace Gaming\ConnectFour\Port\Adapter\Persistence\Projection;

use Gaming\Common\EventStore\StoredEvent;
use Gaming\Common\EventStore\StoredEventSubscriber;
use Gaming\ConnectFour\Application\Game\Query\Model\Game\Game;
use Gaming\ConnectFour\Application\Game\Query\Model\Game\GameStore;
use Gaming\ConnectFour\Port\Adapter\Persistence\Repository\InMemoryCacheGameStore;

final class GameProjection implements StoredEventSubscriber
{
    /**
     * @var GameStore
     */
    private $gameStore;

    /**
     * GameProjection constructor.
     *
     * @param GameStore $gameStore
     */
    public function __construct(GameStore $gameStore)
    {
        $this->gameStore = new InMemoryCacheGameStore(
            $gameStore,
            1000
        );
    }

    /**
     * @inheritdoc
     */
    public function handle(StoredEvent $storedEvent): void
    {
        if ($storedEvent->name() === 'GameOpened') {
            $game = new Game();
        } else {
            $payload = json_decode($storedEvent->payload(), true);
            $game = $this->gameStore->find($payload['gameId']);
        }

        $game->apply($storedEvent);

        $this->gameStore->save($game);
    }

    /**
     * @inheritdoc
     */
    public function isSubscribedTo(StoredEvent $storedEvent): bool
    {
        return in_array(
            $storedEvent->name(),
            [
                'GameOpened',
                'PlayerJoined',
                'PlayerMoved',
                'GameWon',
                'GameDrawn',
                'GameAborted',
                'ChatAssigned'
            ]
        );
    }
}
