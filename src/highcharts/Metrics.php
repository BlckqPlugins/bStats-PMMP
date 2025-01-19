<?php
declare(strict_types=1);
namespace bStats;
use \bStats\charts\CustomChart;
use pocketmine\plugin\PluginBase;
use Ramsey\Uuid\Uuid;

class Metrics {
    public PluginBase $plugin;
    private MetricsSettings $settings;
    private array $charts = [];

    /** @param CustomChart[] $charts */
    public function __construct(PluginBase $plugin){
        assert($plugin !== null, new \InvalidArgumentException("Metrics: \$plugin cannot be null"));
        $this->plugin = $plugin;
    }

    private function initialize_settings(): void{        
        $this->settings = new MetricsSettings($this->plugin);
        if (!$this->settings->load()) {
            $this->settings->server_uuid = Uuid::uuid4()->toString();
            $this->settings->save();
        }
        if ($this->settings->plugin_id === null || gettype($this->settings->plugin_id) === "integer") $this->plugin->getLogger()->notice($this->plugin->getDataFolder()."bStats/config.yml: Key 'plugin_id' must be an integer!");
    }

    public function add(CustomChart $chart): self{
        $this->charts[$chart->custom_id] = $chart;
        return $this;
    }

    public function remove(string $custom_id): self{
        if (isset($this->charts[$custom_id])) unset($this->charts[$custom_id]);
        return $this;
    }

    public function collect_plugin_data(): array{
        $desc = $this->plugin->getDescription();
        return [
            "name" => $desc->getName(),
            "version" => $desc->getVersion(),
            "plugin_id" => $this->settings->plugin_id,
            "charts" => $this->charts,
        ];
    }
}