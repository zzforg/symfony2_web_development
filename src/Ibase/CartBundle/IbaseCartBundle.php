<?php

namespace Ibase\CartBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class IbaseCartBundle extends Bundle
{
    public function getParent() {
        return 'IbaseStoreBundle';
    }
}
