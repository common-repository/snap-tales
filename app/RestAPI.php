<?php

declare(strict_types=1);

namespace BeycanPress\SnapTales;

// Classes
use BeycanPress\SnapTales\PluginHero\BaseAPI;
use BeycanPress\SnapTales\Shortcode\Modes\Mode;
use BeycanPress\SnapTales\PluginHero\Http\Response;

class RestAPI extends BaseAPI
{
    /**
     * @var array<Mode>
     */
    private array $modes;

    /**
     * @param array<Mode> $modes
     */
    public function __construct(array $modes)
    {
        $this->modes = $modes;

        $this->addRoutes([
            'snap-tales' => [
                'get/(?P<mode>\w+)' => [
                    'callback' => 'run',
                    'methods' => ['GET']
                ]
            ]
        ]);
    }

    /**
     * @param \WP_REST_Request $request
     * @return void
     */
    public function run(\WP_REST_Request $request): void
    {
        $modeId = $request->get_param('mode');

        $filteredModes = array_filter($this->modes, function (Mode $_mode) use ($modeId) {
            return $_mode->id == $modeId;
        });

        if (empty($filteredModes)) {
            Response::notFound('Mode not found');
        }

        $mode = array_shift($filteredModes);

        Response::success($modeId, $mode->getArray());
    }
}
