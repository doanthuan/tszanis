<?php

class RoleController extends BaseController {

    public function getIndex()
    {
        $roles = Role::where('role_id','>','2')->get();
        return Response::json($roles);
    }
}
