<?php

namespace Bravesheep\ActiveLinkBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BravesheepActiveLinkBundle extends Bundle
{
    protected $extension;

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new BravesheepActiveLinkExtension();
        }

        return $this->extension;
    }
}
