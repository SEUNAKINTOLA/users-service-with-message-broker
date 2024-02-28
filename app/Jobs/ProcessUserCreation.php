<?php

namespace App\Jobs;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Domain\Models\User;

class ProcessUserCreation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $mqconnection;
    protected $channel;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function handle()
    {

        $this->mqconnection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbitmq'),
            env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_USER', 'guest'),
            env('RABBITMQ_PASSWORD', 'guest'),
            env('RABBITMQ_VHOST', '/')
        );

        $this->channel = $this->mqconnection->channel();


        $userData = [
            'email' => $this->user->email,
            'firstName' => $this->user->firstName,
            'lastName' => $this->user->lastName,
        ];
        $queue = "user_created_queue";

        $this->channel->queue_declare($queue, false, true, false, false);

        $msg = new AMQPMessage(json_encode($userData));
        $this->channel->basic_publish($msg, '', $queue);
        $this->close();
    }

    public function close()
    {
        $this->channel->close();
        $this->mqconnection->close();
    }

    //Added to make this class testable
    public function getUser(){
        return $this->user;
    }
}
