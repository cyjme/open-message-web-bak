<?php
namespace Openmessage\MassPush\Push\Dto;

class PushDto extends DtoBase
{
    protected $pushId;
    protected $createdUserId;
    protected $companyId;
    protected $appId;
    protected $title;
    protected $content;
    protected $toAccId;
    protected $toGroupId;
    protected $created;
    protected $changed;
}
