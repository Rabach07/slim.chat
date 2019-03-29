<?php

namespace App;

class ConversationStatus
{
    const CLOSED = 0;
    const OPEN = 1;
    const UNREAD = 2;

    public static function getStatuses()
    {
        $reflector = new \ReflectionClass(ConversationStatus::class);

        return $reflector->getConstants();
    }

    public static function getKeys()
    {
        $reflector = new \ReflectionClass(ConversationStatus::class);

        return array_keys($reflector->getConstants());
    }

    public static function getValues()
    {
        $reflector = new \ReflectionClass(ConversationStatus::class);

        return array_values($reflector->getConstants());
    }
}
