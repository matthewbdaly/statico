<?php declare(strict_types = 1);

namespace Statico\Core\Utilities;

use Symfony\Component\Yaml\Yaml;

final class YamlWrapper
{
    /**
     * @var Yaml
     */
    private $parser;

    public function __construct(Yaml $parser)
    {
        $this->parser = $parser;
    }

    public function __invoke(string $content): array
    {
        return $this->parser->parse($content);
    }
}
