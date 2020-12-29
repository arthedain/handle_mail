<?php

namespace Arthedain\HandleMail\Http\Controllers;

use Arthedain\HandleMail\Repositories\HandleMailRepository;
use Illuminate\Http\Request;

class MetrikaController
{
    protected HandleMailRepository $handleMailRepository;

    public function __construct(HandleMailRepository $handleMailRepository)
    {
        $this->handleMailRepository = $handleMailRepository;
    }

    public function getByDate(Request $request)
    {
        $mails = $this->handleMailRepository->getByDate($request->from, $request->to, 0);

        return response()->json([
            'mails' => $mails->toArray(),
        ]);
    }

    public function getAll()
    {
        $mails = $this->handleMailRepository->all();

        return response()->json([
            'mails' => $mails,
        ]);
    }

    public function getSpam(Request $request)
    {
        $mails = $this->handleMailRepository->getByDate($request->from, $request->to, 1);

        return response()->json([
            'mails' => $mails,
        ]);
    }

    public function getUser(Request $request)
    {
        $user = $this->handleMailRepository->getByIp($request->ip);

        return response()->json([
            'user' => $user,
        ]);
    }
}
