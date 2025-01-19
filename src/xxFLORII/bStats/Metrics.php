<?php

namespace xxFLORII\bStats;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;
use pocketmine\utils\Internet;
use pocketmine\utils\SingletonTrait;

class Metrics {

    /** @var PluginBase */
    private $plugin;

    /** @var string */
    private $uuid;

    /** @var string */
    private $pluginName;

    /** @var array */
    private $charts = [];

    /** @var int */
    private $pluginId;

    public function __construct(PluginBase $plugin, int $pluginId) {
        $this->plugin = $plugin;
        $this->pluginName = $plugin->getName();
        $this->uuid = $this->generateUUID();
        $this->pluginId = $pluginId;
    }

    /**
     * @param Chart $chart
     */
    public function addCustomChart(Chart $chart) {
        $this->charts[] = $chart;
    }

    private function generateUUID(): string {
        return md5($this->pluginName . time());
    }

    public function sendData() {
        $customCharts = [];

        /** @var Chart $chart */
        foreach ($this->charts as $chart) {
            $customCharts[] = [
                "chartId" => $chart->getId(),
                "data" => $chart->getValue()
            ];
        }

        $data = json_encode([
            "serverUUID" => $this->uuid,
            "metricsVersion" => "3.1.1-SNAPSHOT",
            "service" => [
                "id" => $this->pluginId,
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
        }, 20 * 60 * 30);
    }
}