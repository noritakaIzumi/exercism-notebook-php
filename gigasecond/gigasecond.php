<?php

function from(DateTimeImmutable $dateTime): DateTimeImmutable
{
    $giga = '1000000000';

    return $dateTime->modify(sprintf('+ %s seconds', $giga));
}
