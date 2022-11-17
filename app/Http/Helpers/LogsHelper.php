<?php

use Illuminate\Support\Facades\Log;

function write_logs($func, $level = "info" | "warning" | "error" | "alert" | "critical" | "debug")
{
    if (strtolower($level) == strtolower("info")) {
        Log::info($func, [
            "Login_ID" => auth()->user() ? auth()->user()->id : null,
            "IP Address" => \Illuminate\Http\Request::capture()->getClientIp(),
            "Host" => \Illuminate\Http\Request::capture()->getHttpHost(),
            "Referer" => \Illuminate\Http\Request::capture()->getUri(),
            "Method" => \Illuminate\Http\Request::capture()->getMethod(),
        ]);
    } else if (strtolower($level) == strtolower("warning")) {
        Log::warning($func, [
            "Login_ID" => auth()->user() ? auth()->user()->id : null,
            "IP Address" => \Illuminate\Http\Request::capture()->getClientIp(),
            "Host" => \Illuminate\Http\Request::capture()->getHttpHost(),
            "Referer" => \Illuminate\Http\Request::capture()->getUri(),
            "Method" => \Illuminate\Http\Request::capture()->getMethod(),
        ]);
    } else if (strtolower($level) == strtolower("error")) {
        Log::error($func, [
            "Login_ID" => auth()->user() ? auth()->user()->id : null,
            "IP Address" => \Illuminate\Http\Request::capture()->getClientIp(),
            "Host" => \Illuminate\Http\Request::capture()->getHttpHost(),
            "Referer" => \Illuminate\Http\Request::capture()->getUri(),
            "Method" => \Illuminate\Http\Request::capture()->getMethod(),
        ]);
    } else if (strtolower($func) == strtolower("alert")) {
        Log::alert($func, [
            "Login_ID" => auth()->user() ? auth()->user()->id : null,
            "IP Address" => \Illuminate\Http\Request::capture()->getClientIp(),
            "Host" => \Illuminate\Http\Request::capture()->getHttpHost(),
            "Referer" => \Illuminate\Http\Request::capture()->getUri(),
            "Method" => \Illuminate\Http\Request::capture()->getMethod(),
        ]);
    } else if (strtolower($func) == strtolower("critical")) {
        Log::critical($func, [
            "Login_ID" => auth()->user() ? auth()->user()->id : null,
            "IP Address" => \Illuminate\Http\Request::capture()->getClientIp(),
            "Host" => \Illuminate\Http\Request::capture()->getHttpHost(),
            "Referer" => \Illuminate\Http\Request::capture()->getUri(),
            "Method" => \Illuminate\Http\Request::capture()->getMethod(),
        ]);
    } else if (strtolower($func) == strtolower("debug")) {
        Log::debug($func, [
            "Login_ID" => auth()->user() ? auth()->user()->id : null,
            "IP Address" => \Illuminate\Http\Request::capture()->getClientIp(),
            "Host" => \Illuminate\Http\Request::capture()->getHttpHost(),
            "Referer" => \Illuminate\Http\Request::capture()->getUri(),
            "Method" => \Illuminate\Http\Request::capture()->getMethod(),
        ]);
    }
}
