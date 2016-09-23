<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AssessmentControllerTest extends TestCase
{
    /**
     * @covers AssessmentController::index
     *
     * @return void
     */
    public function testIndex()
    {
        $assessment = factory(App\Assessment::class)->create();
        
        $this->get('api/assessments?sort=-id',
        	$this->getAutHeader())
        	->assertResponseStatus(200)
        	->seeJson($assessment->toArray());
    }
}
