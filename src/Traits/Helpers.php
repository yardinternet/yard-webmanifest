<?php

declare(strict_types=1);

namespace Yard\Webmanifest\Traits;

use Illuminate\View\View;

trait Helpers
{
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
		return config("webmanifest.{$configItem}");
	}

	private function dieAndNotFound(): View
	{
		global $wp_query;
		$wp_query->set_404();
		\status_header(404);

		// @phpstan-ignore-next-line
		if (view()->exists('404')) {
			return view('404');
		} else {
			die();
		}
	}
}
