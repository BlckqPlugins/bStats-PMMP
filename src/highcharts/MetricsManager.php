<?php
declare(strict_types=1);
namespace bStats;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\Internet;
use pocketmine\utils\SingletonTrait;
class MetricsManager {
    use SingletonTrait{
        setInstance as private;
        reset as private;
    }

    /** @var Metrics[] */
    private array $metrics = [];

    public function __construct() {
    }

    protected function collect_server_data(): array{
        $server = Server::getInstance();
        return [
            "osName"        => php_uname("s"),
            "osArch"        => php_uname("m"),
            "osVersion"     => php_uname("v"),
            "coreCount"     => (int)shell_exec("nproc"),
            "onlineMode"    => $server->getOnlineMode() ? 1 : 0,
            "playerAmount"  => count($server->getOnlinePlayers()),
            "bukkitName"    => $server->getName(),
            "serverUUID"    => $server->getServerUniqueId()->toString(),
            //"javaVersion" => "UHHHHHMMMMM..",
        ];
    }

    public function sendData() {
        $server = Server::getInstance();
        $data = json_encode($this->collect_server_data(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        $json = json_encode($data);
        if (json_last_error() !== JSON_ERROR_NONE) $this->plugin->getLogger()->error("Error whilst encoding bStats data: ".json_last_error_msg());
        $compressed = gzencode($json);
        return Internet::postURL("https://bstats.org/api/v2/data/bukkit", $json, 10, [
            "Content-Encoding: gzip",
            "Content-Type: application/json",
            "Content-Length: ".strlen($compressed),
            "User-Agent: MCBE-Server/".$this->plugin->getServer()->getVersion(),
        ]);
    }


    public function scheduleMetricsDataSend() {
        $this->plugin->getScheduler()->scheduleRepeatingTask(new class($this) extends Task {
            private $metrics;

            public function __construct(Metrics $metrics) {
                $this->metrics = $metrics;
            }

            public function onRun(): void {
                $this->metrics->sendData();
            }
        }, 20 * 60 * 10);
    }
}