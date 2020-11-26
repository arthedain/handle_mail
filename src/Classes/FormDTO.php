<?php

namespace Arthedain\HandleMail\Classes;

class FormDTO
{
    private ?string $page;

    private ?string $ip;

    private ?string $name;

    private ?string $email;

    private ?string $phone;

    private ?string $text;

    private ?array $data;

    private ?array $geo;

    public function setPage(?string $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getPage(): ?string
    {
        return $this->page;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setData(?array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): ?array
    {
        if (empty($this->data)) {
            return null;
        }

        return $this->data;
    }

    public function getGeo(): ?array
    {
        return $this->geo;
    }

    public function setGeo(?array $geo): self
    {
        $this->geo = $geo;

        return $this;
    }
}
