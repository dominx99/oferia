<?php

namespace App\Services\Api;

use App\Services\Api\StatusMessage;
use Slim\Http\Response;
use Slim\Http\StatusCode;

trait ApiHelpers
{
    /**
     * @var integer
     */
    protected $status = StatusCode::HTTP_OK;

    /**
     * @var string
     */
    protected $message = StatusMessage::OK;

    /**
     * @param array $params
     * @return \Slim\Http\Response
     */
    public function respondOk(array $params = []): Response
    {
        $this->setStatus(StatusCode::HTTP_OK);
        $this->setMessage(StatusMessage::OK);

        return $this->respond($params);
    }

    /**
     * @param array $params
     * @param integer $status
     * @param string $message
     * @return \Slim\Http\Response
     */
    public function respondError(string $message = null, int $status = null, array $params = []): Response
    {
        if ($status === null) {
            $this->setStatus(StatusCode::HTTP_BAD_REQUEST);
        } else {
            $this->setStatus($status);
        }

        if ($message === null) {
            $this->setMessage(StatusMessage::ERROR);
        } else {
            $this->setMessage($message);
        }

        return $this->respond($params);
    }

    /**
     * @param array $params
     * @param integer $encodingOptions
     * @return \Slim\Http\Response
     */
    protected function respond(array $params, int $encodingOptions = 0): Response
    {
        $params = array_merge(['status' => $this->message], $params);

        return (new Response)->withJson($params, $this->status, $encodingOptions);
    }

    /**
     * @param integer $status
     * @return void
     */
    protected function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param string $message
     * @return void
     */
    protected function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
