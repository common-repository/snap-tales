<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales\Models;

final class AdminStory extends AbstractStory
{
    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct('admin');
    }
}
