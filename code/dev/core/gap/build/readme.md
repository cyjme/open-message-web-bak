./build-project.sh

or

bash <(curl -s http://gap.tecposter.cn/tool/build-project)


./bin/gap buildApp tec/startup
./bin/gap buildModule tec/startup landing


create router: code/dev/app/tec/startup/setting/router/landing.php
```
<?php
$this
    ->site('www')
    ->access('public')
    ->get('/', 'home', 'Tec\Startup\Landing\Ui\HomeController@show');
```

create ui controller: code/dev/app/tec/startup/src/Landing/Ui/HomeController.php

```
<?php
namespace Tec\Startup\Landing\Ui;
class HomeController extends ControllerBase
{
    public function show()
    {
        return $this->view('page/landing/home');
        // or return $this->response('landing home');
    }
}
```

create view: code/dev/app/tec/startup/view/page/landing/home.phtml

```
<h1>home</h1>
```

fix errors:

ERROR: Couldn't connect to Docker daemon - you might need to run `docker-machine start default`

```
$ sudo systemctl daemon-reload
$ sudo systemctl restart docker.service
```
