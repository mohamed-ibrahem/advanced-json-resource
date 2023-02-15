<?php

namespace AdvancedJsonResource\Concerns;

use Illuminate\Http\Request;

trait HasSharedMethod
{
    /**
     * Shared attributes for all responses.
     *
     * @param Request $request
     * @return array
     */
    public function shared(Request $request): array
    {
        return [];
    }
}
