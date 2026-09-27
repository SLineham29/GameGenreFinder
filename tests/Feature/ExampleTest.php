<?php

test('returns a successful response', function () {
    Http::fake([
        'id.twitch.tv/*' => Http::response([
            'access_token' => 'abcd1234',
            'expires_in' => 10,
        ], 200),
        'api.igdb.com/*' => Http::response([], 200),
    ]);

    $response = $this->get('/');

    $response->assertOk();
});
