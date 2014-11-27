<?php

class UserStatus implements \Goxob\Core\Block\Grid\RendererInterface{
    public function render($row)
    {
        return User::getStatusString($row->status);
    }
}