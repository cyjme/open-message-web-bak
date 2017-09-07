<?php
function var2file($targetPath, $var)
{
    file_put_contents(
        $targetPath,
        '<?php return ' . var_export($var, true) . ';'
    );
}

function prop($arr, $key, $default = '')
{
    return isset($arr[$key]) ? $arr[$key] : $default;
}

function obj($object)
{
    return $object;
}

function time_elapsed_string($datetime)
{
    if (is_int($datetime)) {
        $datetime = date(DATE_ATOM, $datetime);
    }
    $datetime = new \DateTime($datetime);
    $now = new \DateTime();
    $diff = $now->diff($datetime);
    if ($diff->y) {
        return $datetime->format('Y-m-d');
    }
    if ($diff->m) {
        return $datetime->format('Y-m-d');
    }
    if ($diff->d) {
        return trans('%d-days-ago', $diff->d);
    }
    if ($diff->h) {
        return trans('%d-hours-ago', $diff->h);
    }
    if ($diff->i) {
        return trans('%d-minutes-ago', $diff->i);
    }
    if ($diff->s) {
        return trans('%d-seconds-ago', $diff->s);
    }

    return trans('just-now');
}

function micro_date($time = null)
{
    if (!$time) {
        $time = microtime(true);
    }

    $date = date_create_from_format('U.u', $time);
    return $date->format('Y-m-d\TH:i:s.u');
}

function gmt_to_locale($time)
{
    $timezone = app()->getConfig()->get('timezone', 'Asia/Shanghai');

    date_default_timezone_set($timezone);

    $offset = obj(new DateTime())->getOffset();

    return date('Y-m-d H:i:s', (new DateTime($time))->getTimeStamp() + $offset);
}

function app($baseDir = '', $type = 'http')
{
    static $app;
    if ($app) {
        return $app;
    }

    if ($type === 'http') {
        $app = new \Gap\App\Http\HttpApp($baseDir);
        return $app;
    }

    if ($type === 'console') {
        $app = new \Gap\App\Console\ConsoleApp($baseDir);
        return $app;
    }

    if ($type == 'open') {
        $app = new \Gap\App\Open\OpenApp($baseDir);
        return $app;
    }
}

function attr_json($arr)
{
    return htmlspecialchars(json_encode($arr), ENT_QUOTES, 'UTF-8');
}

function script_json($obj)
{
    return '<script type="text/json">' . json_encode($obj) . '</script>';
}

function createPush($msg = [])
{
    $config = app()->getConfig()->get('message');
    $msg['key'] = $config['key'];
    $msg['secret'] = $config['secret'];

    $curlRes = curl_init();
    curl_setopt($curlRes, CURLOPT_URL, $config['createPushUrl']);
    curl_setopt($curlRes, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlRes, CURLOPT_POST, 1);
    curl_setopt($curlRes, CURLOPT_POSTFIELDS, $msg);
    $output = curl_exec($curlRes);
    curl_close($curlRes);

    return $output;
}

function current_uid()
{
    static $currentUid;
    static $session;

    if ($currentUid) {
        return $currentUid;
    }

    if ($session) {
        return $session;
    }

    $session = new Symfony\Component\HttpFoundation\Session\Session();


    $currentUid = $session->get('userId');
    return (int) $currentUid;
}

function current_uname()
{
    static $currentUname;
    static $session;

    if ($currentUname) {
        return $currentUname;
    }

    if ($session) {
        return $session;
    }

    $session = new Symfony\Component\HttpFoundation\Session\Session();


    $currentUname = $session->get('userName');
    return (string) $currentUname;
}

function current_user()
{
    static $currentUser;
    if ($currentUser) {
        return $currentUser;
    }

    if ($currentUid = current_uid()) {
        $currentUser = obj(new \Icl\User\User\Service\FetchUserService(app()))->fetchOneByUserId($currentUid);
    }

    return $currentUser;
}
