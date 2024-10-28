<?php

declare(strict_types=1);

namespace Yard\WebmanifestGenerator\Traits;

trait Helpers
{
    /**
     * Make sure config always returns string
     *
     * @param string $configItem
     * @param string $default
     */
    public function getConfig(string $configItem, string $default = ''): string
    {
        $configVal = $this->configValue($configItem);

        return is_string($configVal) ? $configVal : $default;
    }

    /**
     * Make sure config List always returns array
     *
     * @param string $configItem
     * @param array<mixed, mixed> $default
     *
     * @return array<mixed, mixed>
     */
    public function getConfigList(string $configItem, array $default = []): array
    {
        $configVal = $this->configValue($configItem);

        return is_array($configVal) ? $configVal : $default;
    }

    private function configValue(string $configItem): mixed
    {
        return config("yard-waiting-room-block.{$configItem}");
    }
}
