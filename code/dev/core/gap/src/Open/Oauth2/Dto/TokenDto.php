<?php
namespace Gap\Open\Oauth2\Dto;

class TokenDto extends DtoBase
{
    protected $accessToken;
    protected $expiresIn;
    protected $tokenType;
    protected $scope;
    protected $refreshToken;
    protected $userId;
}
