<?php

/**
 * Set the active class for sidebar items.
 *
 * @param array|string $routes
 * @return string
 */
function setActive($routes) {
    if (is_array($routes)) {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return 'active';
            }
        }
    } elseif (is_string($routes)) {
        if (request()->routeIs($routes)) {
            return 'active';
        }
    }
    return '';
}

/**
 * Set the show class for menu items.
 *
 * @param array $routes
 * @return string
 */
function isMenuOpen(array $routes)
{
    foreach ($routes as $route) {
        if (request()->routeIs($route)) {
            return 'show'; // Add the 'show' class to open the collapse.
        }
    }
    return ''; // Return an empty string if no route matches.
}