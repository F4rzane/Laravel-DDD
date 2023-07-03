<?php

namespace App\Application\Traits;

use Closure;
use Illuminate\Support\Facades\Cache;

trait CacheableTrait
{
    protected string $cacheTag;

    protected string $cacheKey;

    protected int $cacheTTL;

    protected string $cacheDriver = 'redis';

    protected string $revalidateCacheKey = 'clearCache';

    public function initializeCache(Closure $closure)
    {
        $this->revalidateCache();

        return Cache::driver($this->getCacheDriver())
            ->tags($this->getCacheTag())
            ->remember(
                $this->getCacheKey(),
                $this->getCacheTTL(),
                $closure
            );
    }

    public function setCacheDriver(string $driverName): static
    {
        $this->cacheDriver = $driverName;

        return $this;
    }

    public function setCacheTag(string $cacheTag): static
    {
        $this->cacheTag = $cacheTag;

        return $this;
    }

    public function setCacheKey(string $cacheKey): static
    {
        $this->cacheKey = $cacheKey;

        return $this;
    }

    public function setCacheTTL(int $cacheTTL): static
    {
        $this->cacheTTL = $cacheTTL;

        return $this;
    }

    public function getCacheTag(): string
    {
        return $this->cacheTag;
    }

    public function getCacheDriver(): string
    {
        return $this->cacheDriver;
    }

    public function getCacheTTL(): string
    {
        return $this->cacheTTL;
    }

    public function getCacheKey(): string
    {
        return $this->cacheKey;
    }

    public function reValidateCache()
    {
        if($this->has($this->revalidateCacheKey)){
            Cache::tags($this->getCacheTag())->delete($this->getCacheKey());
        }
    }

}
