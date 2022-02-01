<?php

if (!function_exists("woven")) {
    function woven()
    {
        return app()->make('laravel-woven');
    }
}