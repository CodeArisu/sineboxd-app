<?php

it('returns a successful response landing page', function () {
    $response = $this->get('/homepage');
    $response->assertStatus(200);
});
