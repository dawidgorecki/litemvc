<?php

namespace Libraries\Core;

interface ActiveRecordInterface
{

    public function getId(): ?int;
    public function setId(int $id);

}