<?php

declare(strict_types=1);

namespace Bone\Notification\PushToken\Form;

use Del\Form\AbstractForm;
use Del\Form\Field\Submit;
use Del\Form\Field\Text;
use Del\Form\Renderer\HorizontalFormRenderer;

class PushTokenForm extends AbstractForm
{
    public function init(): void
    {
        $token = new Text('token');
        $token->setLabel('Token');
        $token->setRequired(true);
        $this->addField($token);

        $submit = new Submit('submit');
        $submit->setClass('btn btn-primary pull-right');
        $this->addField($submit);
        $this->setFormRenderer(new HorizontalFormRenderer());
    }
}
