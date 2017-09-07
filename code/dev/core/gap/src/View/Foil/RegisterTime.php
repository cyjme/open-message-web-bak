<?php
namespace Gap\View\Foil;

class RegisterTime extends RegisterBase
{
    public function register($translator)
    {
        $this->engine->registerFunction(
            'timeElapsed',
            function ($datetime) use ($translator) {
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
                    return $translator->get('days-ago', [$diff->d]);
                }
                if ($diff->h) {
                    return $translator->get('hours-ago', [$diff->h]);
                    //return trans('%d-hours-ago', $diff->h);
                }
                if ($diff->i) {
                    //return trans('%d-minutes-ago', $diff->i);
                    return $translator->get('minutes-ago', [$diff->i]);
                }
                if ($diff->s) {
                    //return trans('%d-seconds-ago', $diff->s);
                    return $translator->get('seconds-ago', [$diff->s]);
                }

                return $translator->get('just-now');
            }
        );
    }
}
