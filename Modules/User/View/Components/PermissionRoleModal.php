<?php

namespace Modules\User\View\Components;

use Illuminate\View\Component;

class PermissionRoleModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $permissions,
        public $target
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('user_module::components.permissions-role-modal');
    }
}
