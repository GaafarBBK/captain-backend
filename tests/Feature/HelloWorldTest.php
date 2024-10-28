<?php

use Tests\TestCase;

beforeEach(function () {
    // Setup code before each test
});

it('should return hello world', function () {
    // Test code
    $response = $this->get('/hello');
    $response->assertStatus(200);
    $response->assertSee('Hello World');
});

afterEach(function () {
    // Teardown code after each test
});

?>