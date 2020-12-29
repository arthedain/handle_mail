<?php

namespace Arthedain\HandleMail\Classes;

interface DTO
{
    public function setPage(?string $page);
    public function getPage();

    public function setIp(?string $ip);
    public function getIp();

    public function setName(?string $name);
    public function getName();

    public function setEmail(?string $email);
    public function getEmail();

    public function setPhone(?string $phone);
    public function getPhone();

    public function setText(?string $text);
    public function getText();

    public function setData(?array $data);
    public function getData();
}
