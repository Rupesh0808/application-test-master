<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class MyApiTest extends TestCase
{
    private $client;
    private $createdId;
    
    public function setUp()
    {
        $this->client = new Client([
            'base_uri' => 'http://192.168.1.130:8080/backend/',
            'http_errors' => false
        ]);
    }
      
    public function testCreateData()
    {
        $response = $this->client->post('data', [
            'json' => [
                'name' => 'RR',
                'state' => 'MP',
                'zip' => 84,
                'amount'=>2500,
                'qty' => 7,
                'item' => 'TV'
            ]
        ]);
        
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getBody());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('id', $data);
        $this->createdId = $data['id'];
    }
    
    public function testUpdateData()
    {
        $response = $this->client->put('data/'.$this->createdId, [
            'json' => [
                'name' => 'RR',
                'state' => 'MP',
                'zip' => 84,
                'amount'=>2500,
                'qty' => 7,
                'item' => 'TV'
            ]
        ]);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
        $data = json_decode($response->getBody(), true);
        $this->assertEquals('Updated Test Data', $data['name']);
        $this->assertEquals('This is an updated test', $data['state']);
        $this->assertEquals(84, $data['zip']);
    }  
    
    public function testDeleteData()
    {
        $response = $this->client->delete('data/'.$this->createdId);
        
        $this->assertEquals(204, $response->getStatusCode());
    }
}