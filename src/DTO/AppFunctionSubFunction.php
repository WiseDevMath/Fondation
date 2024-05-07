<?php

namespace App\DTO;

class AppFunctionSubFunction
{

    public function __construct(
        public readonly ?int  $functionId,
        public readonly ?string $iconName,
        public readonly ?string $functionname,
        public readonly ?int  $subfunctionId,
        public readonly ?string  $subfunctionSlug,
        public readonly ?string $subfunctionname,
        public readonly ?string $level
    )
    {
        
    }
}

?>