<?php

namespace xxFLORII\bStats;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\Internet;
use pocketmine\utils\SingletonTrait;
use xxFLORII\bStats\settings\MetricsSettings;

class Metrics {
    private PluginBase $plugin;
    private MetricsSettings $metricsSettings;

    private array $charts = [];

    public function __construct(PluginBase $plugin) {
        $this->plugin = $plugin;
        $this->metricsSettings = new MetricsSettings($plugin);

        if ($this->metricsSettings->getPluginId() == null || gettype($this->metricsSettings->getPluginId()) != "integer") $plugin->getLogger()->notice($plugin->getDataFolder()."bStats/config.yml: Key 'plugin-id' must be an integer!");
        if ($this->getMetricsSettings()->isEnabled()) {
            Server::getInstance()->getLogger()->info($plugin->getName() . " collect metrics and send them to bStats (https://bStats.org).");
            Server::getInstance()->getLogger()->info("bStats collects some basic information for plugin authors, like how many people use, their plugin and their total player count.");
            Server::getInstance()->getLogger()->info("It's recommended to keep bStats enabled, but if you're not comfortable with this, you can opt-out by editing the config.yml file in the '/bStats/' folder and setting enabled to false.");
        }
    }

    /**
     * @param Chart $chart
     */
    public function addCustomChart(Chart $chart): void
    {
        $this->charts[] = $chart;
    }

    /**
     * @return MetricsSettings
     */
    public function getMetricsSettings(): MetricsSettings
    {
        return $this->metricsSettings;
    }

    public function sendData(): void
    {
        $customCharts = [];

        /** @var Chart $chart */
        foreach ($this->charts as $chart) {
            $customCharts[] = [
                "chartId" => $chart->getId(),
                "data" => $chart->getValue()
            ];
        }

        $server = $this->plugin->getServer();
        if (stristr(PHP_OS, 'win')) {
            $output = trim(shell_exec('wmic cpu get NumberOfCores'));
            $coreCount = preg_match_all('/\d+/', $output, $matches) ? (int) $matches[0][0] : 0;
        } else {
            $coreCount = (int) shell_exec('nproc');
        }

        $optional_data = [
            "onlineMode"    => $server->getOnlineMode() ? 1 : 0,
            "playerAmount"  => count($server->getOnlinePlayers()),
            "bukkitName"    => $server->getName(),
            "osName"        => php_uname("s"),
            "osArch"        => php_uname("m"),
            "osVersion"     => php_uname("v"),
            "coreCount"     => $coreCount,
        ];

        $data = json_encode([
            ...$optional_data,
            "serverUUID" => $this->getMetricsSettings()->getServerUUID(),
            "metricsVersion" => $this->getMetricsSettings()->getMetricsVersion(),
            "service" => [
                "id" => $this->getMetricsSettings()->getPluginId(),
                "customCharts" => $customCharts
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

        if ($response === false || curl_errno($ch) && $this->getMetricsSettings()->isLogFailedRequests()) {
            $this->plugin->getLogger()->error("Error whilst sending data to bStats: " . curl_error($ch));
        }

        curl_close($ch);
    }


    public function scheduleMetricsDataSend(): void
    {
        $this->plugin->getScheduler()->scheduleRepeatingTask(new class($this) extends Task {
            private Metrics $metrics;

            public function __construct(Metrics $metrics) {
                $this->metrics = $metrics;
            }

            public function onRun(): void {
                if ($this->metrics->getMetricsSettings()->isEnabled()) {
                    $this->metrics->sendData();
                }
            }
        }, 20 * 60 * 30);
    }
}