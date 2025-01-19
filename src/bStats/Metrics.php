<?php
declare(strict_types=1);
namespace bStats;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\utils\Internet;
use pocketmine\utils\SingletonTrait;


class Metrics {
    private PluginBase $plugin;
    private MetricsSettings $settings;
    /** @var CustomChart[] */
    private array $charts = [];

    public function __construct(PluginBase $plugin) {
        assert($plugin !== null, new InvalidArgumentException("\$plugin cannot be null"));
        $this->plugin = $plugin;
        $this->settings = new MetricsSettings($plugin);
        if (!$this->settings->load()) {
            $this->settings->server_uuid = md5($this->PluginBase->getDescription()->getName().time()); // TODO: fix me
            $this->settings->save();
        }
        if ($this->settings->plugin_id == null || gettype($this->settings->plugin_id) === "integer") $plugin->getLogger()->notice($plugin->getDataFolder()."bStats/config.yml: Key 'plugin_id' must be an integer!");
    }

    public function addCustomChart(CustomChart $chart) {
        $this->charts[] = $chart;
    }

    public function sendData() {
        $charts = [];
        foreach ($this->charts as $c) {
            $charts[] = $c;
        }

        //\pocketmine\utils\Internet::

        $server = $this->plugin->getServer();
        $optional_data = [
            //"onlineMode"    => $server->getOnlineMode() ? 1 : 0,
            //"javaVersion"   => "UHHHM..",
            "playerAmount"  => count($server->getOnlinePlayers()),
            "bukkitName"    => $server->getName(),
            "osName"        => php_uname("s"),
            "osArch"        => php_uname("m"),
            "osVersion"     => php_uname("v"),
            "coreCount"     => (int)shell_exec("nproc"),
        ];
        $data = json_encode([
            ...$optional_data,
            "serverUUID" => $this->settings->server_uuid,
            "metricsVersion" => "3.1.1-SNAPSHOT",
            "service" => [
                "id" => $this->pluginId,
                "customCharts" => $this->charts
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->plugin->getLogger()->error("JSON Error: " . json_last_error_msg());
        }

        $url = 'https://bstats.org/api/v2/data/bukkit';
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Content-Length: " . strlen($data),
        ]);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        $response = curl_exec($ch);

        if ($response === false || curl_errno($ch)) {
            $this->plugin->getLogger()->error("Error whilst sending data to bStats: " . curl_error($ch));
        }

        curl_close($ch);
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