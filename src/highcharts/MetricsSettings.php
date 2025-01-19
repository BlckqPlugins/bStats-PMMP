<?php
declare(strict_types=1);
namespace bStats;
use configlib\Configuration;
use pocketmine\plugin\PluginBase;

class MetricsSettings extends Configuration {
    public function __construct(PluginBase $plugin) {
        @mkdir($plugin->getDataFolder()."bStats");
        parent::__construct($plugin->getDataFolder()."bStats/config.yml", 0);
    }

    // Is bStats enabled on this server?
    public bool $enabled = true;

    // Should failed requests be logged?
    public bool $log_failed_requests = false;

    // Should the sent data be logged?
    public bool $log_sent_data = false;

    // Should the response text be logged?
    public bool $log_response_status_text = false;

    // The uuid of the server
    public ?string $server_uuid = null;
}
