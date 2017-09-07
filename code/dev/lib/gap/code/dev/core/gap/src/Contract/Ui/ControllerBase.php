<?php
namespace Gap\Contract\Ui;

use Gap\Config\ConfigManager;
use Foil\Foil;
use Gap\View\Foil\RegisterMeta;
use Gap\View\Foil\RegisterTime;
use Gap\View\Foil\RegisterTrans;
use Gap\View\Foil\RegisterUrl;
use Gap\View\Foil\RegisterImg;
use Gap\View\Foil\RegisterCsrf;
use Gap\View\Foil\RegisterUser;
use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class ControllerBase
{
    use \Gap\Contract\Controller\ControllerTrait;

    protected $urlManager;
    protected $fetchUserService;

    public function getMeta()
    {
        return $this->app->getMeta();
    }

    public function getUrlManager()
    {
        if ($this->urlManager) {
            return $this->urlManager;
        }

        $this->urlManager = $this->app->getUrlManager($this->request);
        return $this->urlManager;
    }

    public function getCurrentUserId()
    {
        return $this->request->getUserId();
    }

    public function getCurrentUser()
    {
        if ($userId = $this->getCurrentUserId()) {
            return $this->getUser($userId);
        }

        return null;
    }

    public function getUser($userId)
    {
        return $this->getFetchUserService()
            ->fetchOneByUserId($userId);
    }

    protected function getFetchUserService()
    {
        if ($this->fetchUserService) {
            return $this->fetchUserService;
        }

        $class = $this->config->get('secure.fetchUserService');
        if (!$class) {
            throw new \Exception('no secure.fetchUserService');
        }

        $this->fetchUserService = new $class($this->app);
        return $this->fetchUserService;
    }

    protected function engineRegister($viewEngine)
    {
        if (!$viewEngine) {
            throw new \Exception('view engine is empty');
        }
    }

    protected function getRouter()
    {
        return $this->app->getRouter();
    }

    protected function render($tpl, $data = [])
    {
        //$controller = $this;

        $viewEngine = $this->getViewEngine();
        $viewEngine->useData([
            'app' => $this->app,
            'config' => $this->getConfig(),
            'request' => $this->getRequest(),
            'router' => $this->getRouter(),
        ]);

        obj(new RegisterMeta($viewEngine))->register($this->getMeta());
        obj(new RegisterTrans($viewEngine))->register($this->getTranslator());
        obj(new RegisterUrl($viewEngine))->register($this->getUrlManager());
        obj(new RegisterTime($viewEngine))->register($this->getTranslator());
        obj(new RegisterImg($viewEngine))->register($this->getUrlManager());
        obj(new RegisterCsrf($viewEngine))->register($this->getRequest());
        obj(new RegisterUser($viewEngine))->register($this);

        $this->engineRegister($viewEngine);

        return $viewEngine->render($tpl, $data);
    }

    protected function view($tpl, $data = [])
    {
        return $this->response($this->render($tpl, $data));
    }

    protected function getViewEngine()
    {
        $baseDir = $this->config->get('baseDir');

        $requestApp = $this->getRequest()->getRoute()->getApp();

        $baseDir = $this->config->get('baseDir');
        $folders = [$baseDir . '/dev/view'];
        $folders[] = $baseDir . $this->config->get("app.{$requestApp}.dir") . '/view';

        return Foil::boot([
            'folders' => $folders,
            'autoescape' => false,
            'ext' => 'phtml'
        ])->engine();
    }

    protected function gotoUrl($url, $status = 302)
    {
        return new RedirectResponse($url, $status);
    }

    protected function routeGet($name, $params = [], $query = [], $protocol = '')
    {
        return $this->getUrlManager()->routeGet($name, $params, $query, $protocol);
    }

    // deprecated
    protected function gotoRoute($name, $params = [], $query = [], $protocol = '')
    {
        return $this->gotoRouteGet($name, $params, $query, $protocol);
    }

    protected function gotoRouteGet($name, $params = [], $query = [], $protocol = '')
    {
        return $this->gotoUrl(
            $this->routeGet($name, $params, $query, $protocol)
        );
    }
}
