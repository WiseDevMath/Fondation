<?php

namespace App\DTO;

class AllAuthorizations
{

    public function __construct(
        public readonly ?int  $subfunctionId,
        public readonly ?string $subfunctionname,
        public readonly ?int  $profileId,
        public readonly ?string $profileName,
        public readonly ?string $authorizationId,
        public readonly ?string $level
    )
    {
        
    }
}

?>