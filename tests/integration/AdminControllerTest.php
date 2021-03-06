<?php

class AdminControllerTest extends IntegrationTestCase {

	/** @test */
	public function it_denies_unauthorized_access()
	{
		$this->beUser();
		$this->visit('/admin')
            ->onPage('/home');
	}

	/** @test */
	public function it_redirects_guests()
	{
		$this->visit('/admin')
            ->onPage('/auth/login');
	}

	/** @test */
	public function it_allows_authorized_access()
	{
		$this->beEditor();
		$this->visit('/admin')
            ->onPage('/admin');
            
		$this->beAdmin();
		$this->visit('/admin')
            ->onPage('/admin');
	}
}
