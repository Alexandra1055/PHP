<?php

namespace Core;

final class RequestContext
{
    private static bool $isApi = false;
    private static ?int $userId = null;
    private static ?string $token = null;

    public static function setIsApi(bool $value): void{
        self::$isApi = $value;
    }

    public static function isApi(): bool{
        return self::$isApi;
    }

    public static function setUserId(?int $userId): void{
        self::$userId = $userId;
    }

    public static function userId(): ?int{
        return self::$userId;
    }

    public static function setToken(?string $token): void{
        self::$token = $token;
    }

    public static function token(): ?string{
        return self::$token;
    }
}
