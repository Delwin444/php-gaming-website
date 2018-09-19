<?php
declare(strict_types=1);

namespace Gambling\Common\Application;

final class InvokeApplicationLifeCycle implements ApplicationLifeCycle
{
    /**
     * @inheritdoc
     */
    public function run(callable $action)
    {
        return $action();
    }
}
