<?php

namespace App\WebSockets\Commands;

use App\WebSockets\TinkerServer;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use React\EventLoop\LoopInterface;
use Wilderborn\Partyline\Facade as Partyline;
use Ratchet\App;

class StartWebSocketServerCommand extends Command
{
    protected $signature = 'start-websocket-server';

    protected $description = 'Start the browser facing websocket connection';

    /** @var Application */
    protected $app;

    /** @var LoopInterface */
    protected $loop;

    /** @var TinkerServer */
    protected $tinkerServer;

    public function __construct(Application $app, LoopInterface $loop, TinkerServer $tinkerServer)
    {
        parent::__construct();

        $this->app = $app;
        $this->loop = $loop;
        $this->tinkerServer = $tinkerServer;
    }

    public function handle()
    {
        Partyline::bind($this);

        $host = config('websockets.host');
        $port = config('websockets.port');

        Partyline::info("WebSocket server started on {$host}:{$port} allowing access from localhost only.");

        $app = new App($host, $port, '127.0.0.1', $this->loop);

        $app->route('/ws', $this->tinkerServer, ['*']);

        $app->run();
    }
}
