<?php
declare(strict_types=1);

namespace MadMix\Controller;

use MadMix\Model\Party;

final class PartyController extends BaseController
{
    public function host(): void
    {
        $this->requireAuth();
        $room = Party::createRoom((int)$_SESSION['user']['id']);
        $qr = 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=' . urlencode('https://example.com/party/join?code=' . $room['code']);
        $this->view('party/host', ['room' => $room, 'qr' => $qr]);
    }

    public function join(): void
    {
        $this->view('party/join');
    }

    /** @param array<string,string> $params */
    public function lobby(array $params): void
    {
        $state = Party::stateByCode($params['code']);
        $this->view('party/lobby', ['state' => $state]);
    }
}
