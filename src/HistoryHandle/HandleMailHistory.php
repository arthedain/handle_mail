<?php

namespace Arthedain\HandleMail\HistoryHandle;

use Arthedain\HandleMail\HistoryHandle\Interfaces\History;

class HandleMailHistory implements History
{
    public function set(string $url = ''): void
    {
        $history = [];

        if (!$url) {
            $url = url()->full();
        }

        if (session()->has('handle-history')) {
            $history = session()->get('handle-history');
        }

        if ($this->checkLast($history, $url)) {
            array_push($history, $url);
        }

        session()->put('handle-history', $history);
    }

    public function get(): array
    {
        return session()->get('handle-history') ?? [];
    }

    public function clear(): void
    {
        session()->put('handle-history', []);
    }

    public function checkLast(array $history, string $url): bool
    {
        if (count($history) === 0 || end($history) !== $url) {
            return true;
        }

        return false;
    }
}
