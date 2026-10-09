<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('the welcome path renders the welcome page', function () {
    $response = $this->get('/welcome');

    $response->assertOk()->assertViewIs('welcome');
});
