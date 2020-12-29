<?php

namespace Arthedain\HandleMail\Repositories;

use Arthedain\HandleMail\Models\HandleMail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HandleMailRepository
{
    public function all(): Collection
    {
        return HandleMail::all();
    }

    public function getNotSpam(): Collection
    {
        return HandleMail::notSpam()->get();
    }

    public function getByDate(?string $from = null, ?string $to = null, ?string $spam = null): Collection
    {
        return HandleMail::orderBy('id', 'desc')
            ->from($from)
            ->to($to)
            ->spam($spam)
            ->get();
    }

    public function getById(string $id): HandleMail
    {
        return HandleMail::where('id', $id)->firstOrFail();
    }

    public function getPaginated(int $count, ?string $from = null, ?string $to = null, ?string $search = null): LengthAwarePaginator
    {
        return HandleMail::orderBy('id', 'desc')
            ->from($from)
            ->to($to)
            ->search($search)
            ->notSpam()
            ->paginate($count);
    }

    public function getByIp(?string $ip)
    {
        return HandleMail::where('ip', $ip)->get();
    }
}
