<?php namespace WITR\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'WITR\Services\Registrar'
		);

		if($this->app->environment('local'))
		{
		    $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
		}

		$this->app['view']->composers([
		    'WITR\ViewComposers\UsersViewComposer' => 'shared.user_dropdown',
		    'WITR\ViewComposers\ShowsViewComposer' => 'shared.show_dropdown',
		    'WITR\ViewComposers\VideoViewComposer' => 'home.partials.video',
		]);
	}

}
