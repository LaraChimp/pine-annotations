<?php

namespace LaraChimp\PineAnnotations\Doctrine\Cache;

use Doctrine\Common\Cache\CacheProvider;
use Illuminate\Contracts\Cache\Factory as LaravelCache;

class LaravelCacheDriver extends CacheProvider
{
    /**
     * The Laravel Cache instance.
     *
     * @var LaravelCache
     */
    protected $cache;

    /**
     * LaravelCacheDriver constructor.
     *
     * @param LaravelCache $cache
     */
    public function __construct(LaravelCache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Fetches an entry from the cache.
     *
     * @param string $id The id of the cache entry to fetch.
     *
     * @return mixed|false The cached data or FALSE, if no cache entry exists for the given id.
     */
    protected function doFetch($id)
    {
        return $this->cache->get($id) ?: false;
    }

    /**
     * Tests if an entry exists in the cache.
     *
     * @param string $id The cache id of the entry to check for.
     *
     * @return bool TRUE if a cache entry exists for the given cache id, FALSE otherwise.
     */
    protected function doContains($id)
    {
        return $this->cache->has($id);
    }

    /**
     * Puts data into the cache.
     *
     * @param string $id         The cache id.
     * @param string $data       The cache entry/data.
     * @param int    $lifeTime   The lifetime. If != 0, sets a specific lifetime for this
     *                           cache entry (0 => infinite lifeTime).
     *
     * @return bool TRUE if the entry was successfully stored in the cache, FALSE otherwise.
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        // We have no lifetime
        // so cache forever.
        if ($lifeTime == 0) {
            $this->cache->forever($id, $data);
        } else {
            $this->cache->put($id, $data, $lifeTime);
        }

        return $this->doContains($id);
    }

    /**
     * Deletes a cache entry.
     *
     * @param string $id The cache id.
     *
     * @return bool TRUE if the cache entry was successfully deleted, FALSE otherwise.
     */
    protected function doDelete($id)
    {
        return $this->cache->forget($id);
    }

    /**
     * Flushes all cache entries.
     *
     * @return bool TRUE if the cache entries were successfully flushed, FALSE otherwise.
     */
    protected function doFlush()
    {
        return $this->cache->flush();
    }

    /**
     * Retrieves cached information from the data store.
     *
     * @since 2.2
     *
     * @return array|null An associative array with server's statistics if available, NULL otherwise.
     */
    protected function doGetStats()
    {
        return null;
    }
}
