<?php

class ProjectTest extends CDbTestCase
{
    public $fixtures = array(
        'projects' => 'Project',
        'users' => 'User',
        'projUsrAssign' => ':tbl_project_user_assignment',
    );

    public function testCreate()
    {
        // Create a new project
        $newProject = new Project();
        $newProjectName = 'Test Project Creation';
        $newProject->setAttributes(array(
            'name' => $newProjectName,
            'description' => 'This is a test for new project creation',
        ));

        // Set the application user id to the first user in our fixture data
        Yii::app()->user->setId($this->users('user1')->id);
        $this->assertTrue($newProject->save());

        // Read back the newly created Project to ensure the creation worked
        $retrievedProject = Project::model()->findByPk($newProject->id);

        $this->assertTrue($retrievedProject instanceof Project);
        $this->assertEquals($newProjectName, $retrievedProject->name);

        // Ensure the user associated with creating the new project is the same as the application user we set when saving the project
        $this->assertEquals(Yii::app()->user->id, $retrievedProject->create_user_id);
    }

    public function testRead()
    {
        // Read a project
        $retrievedProject = $this->projects('project1');

        $this->assertTrue($retrievedProject instanceof Project);
        $this->assertEquals('Test Project 1', $retrievedProject->name);
    }

    public function testUpdate()
    {
        // Update a project
        $project = $this->projects('project2');
        $updatedProjectName = 'Updated Test Project 2';
        $project->name = $updatedProjectName;

        $this->assertTrue($project->save(false));

        // Read back the newly updated project
        $updatedProject = Project::model()->findByPk($project->id);

        $this->assertTrue($updatedProject instanceof Project);
        $this->assertEquals($updatedProjectName, $updatedProject->name);
    }

    public function testDelete()
    {
        $project = $this->projects('project2');
        $savedProjectId = $project->id;

        $this->assertTrue($project->delete());

        $deletedProject = Project::model()->findByPk($savedProjectId);

        $this->assertEquals(null, $deletedProject);
    }

    public function testGetUserOptions()
    {
        $project = $this->projects('project1');
        $options = $project->userOptions;

        $this->assertTrue(is_array($options));
        $this->assertTrue(count($options) > 0);
    }
}