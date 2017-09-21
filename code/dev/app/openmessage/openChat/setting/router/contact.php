<?php
$this
    ->site('www') 
    ->access('public')

    ->postOpen('/open/list-contact', 'listContact', 'Openmessage\OpenChat\Contact\Open\ListContactController@ListByAccToken');
