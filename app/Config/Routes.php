<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Home
$routes->get('/', 'Home::index');

// Currency Converter
$routes->get('currency', 'Currency::index');
$routes->post('currency/convert', 'Currency::convert');
$routes->get('currency/rates', 'Currency::rates');

// Weight Converter
$routes->get('weight', 'Weight::index');
$routes->post('weight/convert', 'Weight::convert');

// Temperature Converter
$routes->get('temperature', 'Temperature::index');
$routes->post('temperature/convert', 'Temperature::convert');

// Length Converter
$routes->get('length', 'Length::index');
$routes->post('length/convert', 'Length::convert');

// Area Converter
$routes->get('area', 'Area::index');
$routes->post('area/convert', 'Area::convert');

// Speed Converter
$routes->get('speed', 'Speed::index');
$routes->post('speed/convert', 'Speed::convert');

// Data Storage Converter
$routes->get('data-storage', 'DataStorage::index');
$routes->post('data-storage/convert', 'DataStorage::convert');

// Timezone Converter
$routes->get('timezone', 'Timezone::index');
$routes->post('timezone/convert', 'Timezone::convert');

// API (AJAX endpoints)
$routes->get('api/rates', 'Api::rates');
$routes->post('api/currency', 'Api::currency');
$routes->post('api/convert', 'Api::convert');
