<?php

namespace Arthedain\HandleMail\HistoryHandle\Interfaces;

interface History
{
    public function set(): void;

    public function get(): array;

    public function clear(): void;
}
