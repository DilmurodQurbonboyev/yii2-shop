<?php

namespace frontend\controllers\auth;

use shop\services\auth\NetworkService;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\authclient\AuthAction;

class NetworkController extends Controller
{
    private $service;

    public function __construct($id, $module, NetworkService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }


    public function actions()
    {
        return [
            'auth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess(ClientInterface $client): void
    {

        $network = $client->getId();
        $attributes = $client->getUserAttributes();
        $identity = ArrayHelper::getValue($attributes, 'id');

        try {
            $this->service->attach(Yii::$app->user->id, $network, $identity);
            Yii::$app->session->setFlash('success', 'Network is successfully attached.');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }
}
