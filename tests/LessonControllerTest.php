<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class LessonControllerTest extends TestCase
{
    /**
     * @covers LessonController::index
     *
     * @return void
     */
    public function testIndex()
    {
        $lesson = factory(\App\Lesson::class)->create();

    	$this->get('api/lessons?sort=-id',$this->getAutHeader())
    		->assertResponseStatus(200)
    		->seeJson($lesson->toArray());
    }

    /**
     * @covers LessonController::store
     *
     * @return void
     */
    public function testStore()
    {
    	$lesson = factory(App\Lesson::class)->make()->toArray();
        
        $this->post('api/lessons',
        	$lesson,
        	$this->getAutHeader())
        	->assertResponseStatus(201)
        	->seeJson($lesson);
    }

    /**
     * @covers LessonController::show
     *
     * @return void
     */
    public function testShow()
    {
        $lesson = factory(App\Lesson::class)->create();
        
        $this->get("api/lessons/$lesson->id",
            $this->getAutHeader())
            ->assertResponseStatus(200)
            ->seeJson($lesson->toArray());
    }

    /**
     * @covers LessonController::update
     *
     * @return void
     */
    public function testUpdate()
    {
        $lesson = factory(App\Lesson::class)->create();
        $lesson_changed = factory(App\Lesson::class)->make()->toArray();
        
        $this->put("api/lessons/{$lesson->id}",
            $lesson_changed,
            $this->getAutHeader())
            ->assertResponseStatus(200)
            ->seeJson($lesson_changed);
    }

    /**
     * @covers LessonController::destroy
     * 
     * @return void
     */
    public function testDestroy()
    {
        $lesson = factory(\App\Lesson::class)->create();

        $this->delete("api/lessons/{$lesson->id}",
            [],
            $this->getAutHeader())
            ->assertResponseStatus(204)
            ->dontSeeInDatabase('lessons', ['id' => $lesson->id]);
    }

}