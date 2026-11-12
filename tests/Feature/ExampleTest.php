<?php

test('guests opening the home page are sent to login', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('login'));
});
